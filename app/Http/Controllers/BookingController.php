<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\User;
use App\Models\FieldData;
use App\Models\FieldSchedule;
use App\Models\ScheduleAvailability;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with('bookingDetails', 'fieldData')->get();
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
        $selectedDate = $request->has('schedule_play') ? $request->schedule_play : null;


        $fieldSchedules = FieldSchedule::with('scheduleAvailabilities')->get();

        return view('admin.owner.booking.create', compact('fieldData', 'fieldSchedules', 'selectedDate'));
    }

    public function checkAvailability($id, Request $request)
    {
        $selectedDate = $request->schedule_play;
        $fieldData = FieldData::find($id);
        $fieldSchedules = FieldSchedule::whereNotIn('id', function ($query) use ($fieldData,$selectedDate) {
            $query->select('field_schedule_id')
                ->from('schedule_availabilities')
                ->where('field_data_id', $fieldData->id)
                ->where('schedule_date', $selectedDate)
                ->where('is_available', 0);
        })->get();

        // dd($fieldSchedules);
        return view('admin.owner.booking.create', compact('selectedDate', 'fieldData', 'fieldSchedules'));
    }


    public function store(Request $request)
    {
        $user = auth()->user();

        // Validasi input
        $request->validate([
            'field_data_id' => 'required',
            'selected_schedules' => 'required|array|min:1',
            'schedule' => 'required|date',
        ]);

        // Buat booking jika validasi berhasil
        $booking = Booking::create([
            'field_data_id' => $request->field_data_id,
        ]);

        $selectedSchedules = $request->selected_schedules;

        $totalSubtotal = 0; // Inisialisasi total sub total
        foreach ($selectedSchedules as $scheduleId) {

            $fieldSchedule = FieldSchedule::find($scheduleId);

            // Pastikan fieldSchedule yang ditemukan tidak null
            if ($fieldSchedule) {
                // Cari FieldData berdasarkan field_data_id yang dipilih dalam BookingDetail
                $fieldData = FieldData::find($request->field_data_id);

                // Hitung subtotal berdasarkan harga dari FieldData yang sesuai
                $subTotal = $fieldData->price;
                $totalSubtotal += $subTotal; // Tambahkan subtotal ke total sub total

                // Buat BookingDetail
                BookingDetail::create([
                    'booking_id' => $booking->id,
                    'schedule_play' => $request->schedule,
                    'field_schedule_id' => $scheduleId,
                    'sub_total' => $subTotal,
                ]);

                // Tandai jadwal sebagai tidak tersedia pada tanggal tersebut di ScheduleAvailability
                ScheduleAvailability::create([
                    'field_data_id' => $request->field_data_id,
                    'field_schedule_id' => $scheduleId,
                    'schedule_date' => $request->schedule,
                    'is_available' => false,
                ]);
            }
        }

        // Simpan total sub total ke dalam tabel booking
        $booking->total_subtotal = $totalSubtotal;
        $booking->save();

        if ($user->role_id == 1) {
            session()->flash('success', 'Data lapangan berhasil ditambahkan');
            return redirect()->route('owner.bookingIndex');
        } else if ($user->role_id == 2) {
            session()->flash('success', 'Data lapangan berhasil ditambahkan');
            return redirect()->route('advisor.bookingIndex');
        }
    }
}
