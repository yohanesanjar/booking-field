<?php

namespace App\Http\Controllers;

use App\Models\FieldData;
use App\Models\FieldSchedule;
use App\Models\ScheduleAvailability;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FieldsController extends Controller
{
    public function indexField()
    {
        $user = auth()->user();
        $fieldData = FieldData::all();

        return view('admin.fields.data.index', compact('fieldData'));
    }

    public function createField()
    {
        return view('admin.fields.data.create');
    }

    public function storeField(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'field_type' => 'required',
            'field_material' => 'required',
            'field_location' => 'required',
            'morning_price' => 'required|gt:0',
            'night_price' => 'required|gt:0',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg|max:10240', // Adjust the validation rules as needed
        ], [
            'name.required' => 'Nama harus diisi',
            'description.required' => 'Deskripsi harus diisi',
            'field_type.required' => 'Jenis lapangan harus diisi',
            'field_material.required' => 'Material lapangan harus diisi',
            'field_location.required' => 'Lokasi lapangan harus diisi',
            'morning_price.required' => 'Harga jam pagi harus diisi',
            'morning_price.gt' => 'Harga jam pagi tidak boleh 0',
            'night_price.required' => 'Harga jam malam harus diisi',
            'night_price.gt' => 'Harga jam malam tidak boleh 0',
            'thumbnail.required' => 'Thumbnail harus diisi',
            'thumbnail.image' => 'File harus berupa gambar',
            'thumbnail.mimes' => 'File harus berupa jpeg, png, atau jpg',
            'thumbnail.max' => 'File tidak boleh lebih dari 2 MB',
        ]);

        $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public'); // Assuming 'thumbnails' is the storage folder

        FieldData::create([
            'name' => $request->name,
            'description' => $request->description,
            'field_type' => $request->field_type,
            'field_material' => $request->field_material,
            'field_location' => $request->field_location,
            'morning_price' => $request->morning_price,
            'night_price' => $request->night_price,
            'thumbnail' => $thumbnailPath,
        ]);

        session()->flash('success', 'Data lapangan berhasil ditambahkan');
        return redirect()->route('admin.fieldIndex');
    }

    public function editField($id)
    {
        $fieldData = FieldData::find($id);

        if (!$fieldData) {
            return view('admin.404');
        }

        return view('admin.fields.data.edit', compact('fieldData'));
    }

    public function updateField(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'field_type' => 'required',
            'field_material' => 'required',
            'field_location' => 'required',
            'morning_price' => 'required|gt:0',
            'night_price' => 'required|gt:0',
            'thumbnail' => 'image|mimes:jpeg,png,jpg', // Allow empty or image files
        ], [
            'name.required' => 'Nama harus diisi',
            'description.required' => 'Deskripsi harus diisi',
            'field_type.required' => 'Jenis lapangan harus diisi',
            'field_material.required' => 'Material lapangan harus diisi',
            'field_location.required' => 'Lokasi lapangan harus diisi',
            'morning_price.required' => 'Harga jam pagi harus diisi',
            'morning_price.gt' => 'Harga jam pagi tidak boleh 0',
            'night_price.required' => 'Harga jam malam harus diisi',
            'night_price.gt' => 'Harga jam malam tidak boleh 0',
            'thumbnail.image' => 'File harus berupa gambar',
            'thumbnail.mimes' => 'File harus berupa jpeg, png, atau jpg',
        ]);

        $fieldData = FieldData::find($id);

        // Hapus gambar lama jika ada gambar baru yang diberikan
        if ($request->hasFile('thumbnail')) {
            // Hapus gambar lama dari sistem penyimpanan
            if ($fieldData->thumbnail) {
                Storage::disk('public')->delete($fieldData->thumbnail);
            }

            // Simpan gambar baru dan dapatkan path-nya
            $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
            $fieldData->thumbnail = $thumbnailPath;
        }

        $fieldData->update([
            'name' => $request->name,
            'description' => $request->description,
            'field_type' => $request->field_type,
            'field_material' => $request->field_material,
            'field_location' => $request->field_location,
            'morning_price' => $request->morning_price,
            'night_price' => $request->night_price,
        ]);

        session()->flash('success', 'Data lapangan berhasil diubah');
        return redirect()->route('admin.fieldIndex');
    }


    public function destroyField($id)
    {
        $fieldData = FieldData::find($id);
        if (!$fieldData) {
            session()->flash('error', 'Data lapangan tidak ditemukan');
            return redirect()->back();
        }

        // Hapus file gambar dari penyimpanan
        Storage::disk('public')->delete($fieldData->thumbnail);

        $fieldData->delete();
        session()->flash('success', 'Data lapangan berhasil dihapus');
        return redirect()->route('admin.fieldIndex');
    }

    // Field Schedule
    public function indexSchedule()
    {
        $fieldSchedule = FieldSchedule::all();
        return view('admin.fields.schedule.index', compact('fieldSchedule'));
    }

    public function updateSchedule(Request $request, $id)
    {
        $fieldSchedule = FieldSchedule::find($id);

        // Menggunakan operasi ternary untuk menetapkan nilai is_active sesuai dengan checkbox
        $isActive = $request->has('is_active') ? 1 : 0;

        $fieldSchedule->update([
            'is_active' => $isActive,
        ]);

        session()->flash('success', 'Jadwal lapangan berhasil diubah');
        return redirect()->route('admin.scheduleIndex');
    }

    public function indexScheduleActive()
    {
        $scheduleAvailable = ScheduleAvailability::with(['booking', 'fieldData', 'fieldSchedule'])
            ->whereHas('booking', function ($query) {
                $query->where('is_member', 0);
            })
            ->get();
        return view('admin.fields.schedule.scheduleActive', compact('scheduleAvailable'));
    }

    public function destroyScheduleActive(Request $request)
    {
        $ids = $request->input('ids', []);

        // Pastikan $ids adalah array yang valid dan tidak kosong
        if (!is_array($ids) || empty($ids)) {
            return response()->json(['error' => 'Invalid or empty IDs array'], 400);
        }

        try {
            // Periksa apakah ada jadwal yang terkait dengan booking yang memiliki status 4
            $bookingsWithPaidStatus = ScheduleAvailability::whereIn('id', $ids)
                ->whereHas('booking', function ($query) {
                    $query->where('booking_status', 4);
                })->exists();

            if ($bookingsWithPaidStatus) {
                return response()->json(['error' => 'Schedule cannot be deleted because booking status is already paid'], 400);
            }

            // Hapus data berdasarkan ID yang diberikan
            ScheduleAvailability::whereIn('id', $ids)->delete();

            // Beri respons sukses
            return response()->json(['message' => 'Data successfully removed'], 200);
        } catch (\Exception $e) {
            // Tangani jika terjadi kesalahan saat menghapus data
            return response()->json(['error' => 'Failed to remove data'], 500);
        }
    }
}
