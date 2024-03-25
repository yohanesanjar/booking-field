<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\User;
use App\Models\FieldData;
use App\Models\FieldSchedule;
use App\Models\PaymentMethod;
use App\Models\ScheduleAvailability;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with('bookingDetails', 'fieldData', 'transactions.paymentMethod')->get();
        return view('admin.owner.booking.index', compact('bookings'));
    }

    public function chooseField()
    {
        $fieldDatas = FieldData::all();
        return view('admin.owner.booking.chooseField', compact('fieldDatas'));
    }

    public function create($id, Request $request)
    {
        $fieldData = FieldData::find($id);
        $schedule_play = Carbon::now()->format('Y-m-d');
        $fieldSchedules = FieldSchedule::with(['scheduleAvailabilities' => function ($query) use ($fieldData, $schedule_play) {
            $query->where('field_data_id', $fieldData->id)
                ->where('schedule_date', $schedule_play);
        }])->get();

        $paymentMethods = PaymentMethod::all();

        return view('admin.owner.booking.create', compact('fieldData', 'fieldSchedules', 'schedule_play', 'paymentMethods'));
    }

    public function checkAvailability(Request $request)
    {
        $selectedDate = $request->schedule_play;
        $fieldDataId = $request->field_data_id;

        // Ubah input field_data_id menjadi integer
        $fieldDataId = (int) $fieldDataId;

        // Ambil data FieldData berdasarkan id
        $fieldData = FieldData::find($fieldDataId);

        // Pastikan FieldData ditemukan
        if (!$fieldData) {
            return response()->json(['error' => 'FieldData not found'], 404);
        }

        $fieldSchedules = FieldSchedule::with(['scheduleAvailabilities' => function ($query) use ($fieldData, $selectedDate) {
            $query->where('field_data_id', $fieldData->id)
                ->where('schedule_date', $selectedDate);
        }])->get();

        return response()->json($fieldSchedules);
    }

    public function getSession(Request $request)
    {
        $user = auth()->user();

        // Validasi input
        $request->validate([
            'customer_name' => 'required',
            'selected_schedules' => 'required',
            'schedule_play' => 'required|date',
        ], [
            'customer_name.required' => 'Nama Pelanggan harus diisi.',
            'schedule_play.required' => 'Anda harus memilih jadwal tanggal bermain',
            'selected_schedules.required' => 'Anda harus memilih jam bermain.',
        ]);

        // Tentukan apakah pelanggan adalah member
        $isMember = $request->has('is_member') ? true : false;

        // Jika pelanggan adalah member, pastikan ada 3 jadwal yang dipilih
        if ($isMember && count($request->selected_schedules) != 3) {
            return back()->with('error', 'Jika Anda ingin menjadi member, Anda harus memilih 3 jadwal.');
        }

        // Simpan data booking ke dalam sesi
        $bookingData = [
            'field_data_id' => $request->field_data_id,
            'customer_name' => $request->customer_name,
            'is_member' => $isMember,
            'discount' => $isMember ? 85000 : 0,
            'booking_status' => false,
            'selected_schedules' => [],
            'total_before_discount' => 0,
            'total_after_discount' => 0,
        ];

        // Jika pelanggan adalah member, lakukan logika untuk member
        if ($isMember) {
            // Iterasi melalui tanggal jadwal
            $selectedDates = [];
            $scheduleDate = Carbon::parse($request->schedule_play);
            while (count($selectedDates) < 4) {
                $selectedDates[] = $scheduleDate->format('Y-m-d');
                $scheduleDate->addDays(7);
            }

            // Iterasi melalui tanggal jadwal yang dipilih
            foreach ($selectedDates as $date) {
                foreach ($request->selected_schedules as $scheduleId) {
                    $fieldSchedule = FieldSchedule::find($scheduleId);

                    if ($fieldSchedule) {
                        $fieldData = FieldData::find($request->field_data_id);
                        $subTotal = ($scheduleId <= 11) ? $fieldData->morning_price : $fieldData->night_price;

                        // Tambahkan harga ke total sebelum diskon
                        $bookingData['total_before_discount'] += $subTotal;

                        // Tambahkan detail jadwal ke dalam data booking
                        $bookingData['selected_schedules'][] = [
                            'schedule_play' => $date,
                            'field_schedule_id' => $scheduleId,
                            'start_time' => $fieldSchedule->start_time, // Tambahkan start_time
                            'end_time' => $fieldSchedule->end_time,
                            'sub_total' => $subTotal,
                        ];
                    }
                }
            }

            // Hitung total setelah diskon
            $bookingData['total_after_discount'] = $bookingData['total_before_discount'] - $bookingData['discount'];

            // Jika pelanggan bukan member, lakukan logika untuk non-member
        } else {
            // Iterasi melalui jadwal yang dipilih
            foreach ($request->selected_schedules as $scheduleId) {
                $fieldSchedule = FieldSchedule::find($scheduleId);

                if ($fieldSchedule) {
                    $fieldData = FieldData::find($request->field_data_id);
                    $subTotal = ($scheduleId <= 11) ? $fieldData->morning_price : $fieldData->night_price;

                    // Tambahkan harga ke total sebelum diskon
                    $bookingData['total_before_discount'] += $subTotal;

                    // Tambahkan detail jadwal ke dalam data booking
                    $bookingData['selected_schedules'][] = [
                        'schedule_play' => $request->schedule_play,
                        'field_schedule_id' => $scheduleId,
                        'start_time' => $fieldSchedule->start_time, // Tambahkan start_time
                        'end_time' => $fieldSchedule->end_time,
                        'sub_total' => $subTotal,
                    ];
                }
            }

            // Hitung total setelah diskon
            $bookingData['total_after_discount'] = $bookingData['total_before_discount'] - $bookingData['discount'];
        }

        // Simpan data booking ke dalam sesi
        session()->put('booking_data', $bookingData);

        // Redirect pengguna ke halaman transaksi
        if ($user->role_id == 1) {
            return redirect()->route('owner.transaction');
        } elseif ($user->role_id == 2) {
            session()->flash('success', 'Data lapangan berhasil ditambahkan');
            return redirect()->route('advisor.bookingIndex');
        }
    }

    public function transaction()
    {
        $bookingData = session('booking_data');
        $fieldData = FieldData::find($bookingData['field_data_id']);
        $paymentMethods = PaymentMethod::all();
        // dd($fieldData);
        return view('admin.owner.transaction.transaction', compact('bookingData', 'fieldData', 'paymentMethods'));
    }

    public function storeTransaction(Request $request)
    {
        $user = auth()->user();
        $bookingData = session('booking_data');
        if ($bookingData['is_member'] == true) {

            $request->validate([
                'payment_method' => 'required',
            ], [
                'payment_method.required' => 'Pilih metode pembayaran',
            ]);
        } else {
            $request->validate([
                'payment_method' => 'required',
                'down_payment' => 'required',
            ], [
                'payment_method.required' => 'Pilih metode pembayaran',
                'down_payment.required' => 'Masukkan nominal dp',
            ]);
        }

        if ($request->payment_method != 1) {
            $request->validate([
                'payment_proof' => 'required|mimes:jpg,jpeg,png|max:2048',
                'account_name' => 'required',
            ], [
                'payment_proof.required' => 'Masukkan bukti pembayaran',
                'account_name.required' => 'Masukkan nama akun pembayaran',
            ]);

            $paymentProofPath = $request->file('payment_proof')->store('payment-proofs', 'public');
        }else{
            $paymentProofPath = null;
        }

        // Tentukan apakah pelanggan adalah member
        $isMember = $request->is_member;

        if ($isMember) {
            $booking = Booking::create([
                'field_data_id' => $request->field_data_id,
                'customer_name' => $request->customer_name,
                'is_member' => $isMember, // Atur status member
                'discount' => $isMember ? 85000 : 0, // Berikan diskon jika member
                'booking_status' => false,
            ]);

            // Iterasi melalui tanggal jadwal
            $selectedDates = [];
            $scheduleDate = Carbon::parse($request->schedule_play);
            while (count($selectedDates) < 4) {
                $selectedDates[] = $scheduleDate->format('Y-m-d');
                $scheduleDate->addDays(7);
            }

            // Iterasi melalui tanggal jadwal yang dipilih
            foreach ($selectedDates as $date) {
                foreach ($request->selected_schedules as $scheduleId) {
                    // Periksa apakah jadwal ini sudah pernah dimasukkan sebelumnya
                    $existingBookingDetail = BookingDetail::where('booking_id', $booking->id)
                        ->where('schedule_play', $date)
                        ->where('field_schedule_id', $scheduleId)
                        ->exists();

                    if (!$existingBookingDetail) {
                        $fieldSchedule = FieldSchedule::find($scheduleId);

                        if ($fieldSchedule) {
                            $fieldData = FieldData::find($request->field_data_id);
                            $subTotal = ($scheduleId <= 11) ? $fieldData->morning_price : $fieldData->night_price;

                            // Tambahkan detail booking
                            $booking->bookingDetails()->create([
                                'booking_id' => $booking->id,
                                'schedule_play' => $date,
                                'field_schedule_id' => $scheduleId,
                                'sub_total' => $subTotal,
                            ]);

                            // Tandai jadwal sebagai tidak tersedia pada tanggal tersebut di ScheduleAvailability
                            ScheduleAvailability::create([
                                'booking_id' => $booking->id,
                                'field_data_id' => $request->field_data_id,
                                'field_schedule_id' => $scheduleId,
                                'schedule_date' => $date,
                                'is_available' => false,
                            ]);
                        }
                    }
                }
            }

            // Hitung total setelah diskon
            $totalBeforeDiscount = $booking->bookingDetails()->sum('sub_total');
            $totalAfterDiscount = $totalBeforeDiscount - $booking->discount;

            // Simpan total_subtotal (total setelah diskon) ke dalam tabel booking
            $booking->total_subtotal = $totalAfterDiscount;
            $booking->save();
        } else {
            $discount = $request->discount ?? 0;
            // Buat booking jika validasi berhasil
            $booking = Booking::create([
                'field_data_id' => $request->field_data_id,
                'customer_name' => $request->customer_name,
                'discount' => $discount,
                'down_payment' => $request->down_payment,
                'booking_status' => false,
            ]);

            $totalBeforeDiscount = 0;

            foreach ($request->selected_schedules as $scheduleId) {
                $fieldSchedule = FieldSchedule::find($scheduleId);

                if ($fieldSchedule) {
                    $fieldData = FieldData::find($request->field_data_id);
                    $subTotal = ($scheduleId <= 11) ? $fieldData->morning_price : $fieldData->night_price;

                    // Tambahkan harga ke total sebelum diskon
                    $totalBeforeDiscount += $subTotal;

                    // Buat booking detail
                    $bookingDetail = $booking->bookingDetails()->create([
                        'booking_id' => $booking->id,
                        'schedule_play' => $request->schedule_play,
                        'field_schedule_id' => $scheduleId,
                        'sub_total' => $subTotal,
                    ]);

                    // Tandai jadwal sebagai tidak tersedia pada tanggal tersebut di ScheduleAvailability
                    ScheduleAvailability::create([
                        'booking_id' => $booking->id,
                        'field_data_id' => $request->field_data_id,
                        'field_schedule_id' => $scheduleId,
                        'schedule_date' => $request->schedule_play,
                        'is_available' => false,
                    ]);
                }
            }

            // Hitung total setelah diskon
            $totalAfterDiscount = $totalBeforeDiscount - $booking->discount;

            // Simpan total_subtotal (total setelah diskon) ke dalam tabel booking
            $booking->total_subtotal = $totalAfterDiscount;
            $booking->save();
        }

        $transaction = Transaction::create([
            'booking_id' => $booking->id,
            'user_id' => $user->id,
            'payment_method_id' => $request->payment_method,
            'payment_proof' => $paymentProofPath,
            'account_name' => $request->account_name,

        ]);

        if ($user->role_id == 1) {
            $booking = Booking::find($booking->id);
            $booking->update([
                'booking_status' => true,
            ]);
        }


        session()->forget('booking_data');
        // Buat booking jika validasi berhasil
        if ($user->role_id == 1) {
            session()->flash('success', 'Data booking berhasil ditambahkan');
            // Redirect pengguna ke halaman transaksi
            return redirect()->route('owner.bookingIndex');
            // return redirect()->route('owner.bookingIndex');
        } else if ($user->role_id == 2) {
            session()->flash('success', 'Data lapangan berhasil ditambahkan');
            return redirect()->route('advisor.bookingIndex');
        }
    }

    public function paymentTransaction($id)
    {
        session()->forget('booking_data');
        $transaction = Transaction::find($id);
        dd($transaction);
        return view('admin.owner.transaction.payment', compact('transaction'));
    }
}
