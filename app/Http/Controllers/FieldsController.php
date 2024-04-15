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
        if ($user->role_id == 1) {
            $fieldData = FieldData::all();
            return view('admin.owner.fields.data.index', compact('fieldData'));
        } else if ($user->role_id == 2) {
            return view('admin.advisor.fields.data.index');
        }
    }

    public function createField()
    {
        return view('admin.owner.fields.data.create');
    }

    public function storeField(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'field_type' => 'required',
            'field_material' => 'required',
            'field_location' => 'required',
            'morning_price' => 'required|gt:0',
            'night_price' => 'required|gt:0',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Adjust the validation rules as needed
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

        if ($user->role_id == 1) {
            session()->flash('success', 'Data lapangan berhasil ditambahkan');
            return redirect()->route('owner.fieldIndex');
        } else if ($user->role_id == 2) {
            session()->flash('success', 'Data lapangan berhasil ditambahkan');
            return redirect()->route('advisor.field');
        }
    }

    public function editField($id)
    {
        $user = auth()->user();
        $fieldData = FieldData::find($id);

        if (!$fieldData) {
            return view('admin.owner.404');
        }

        if ($user->role_id == 1) {
            return view('admin.owner.fields.data.edit', compact('fieldData'));
        } else if ($user->role_id == 2) {
            return view('admin.advisor.fields.data.edit', compact('fieldData'));
        }
    }

    public function updateField(Request $request, $id)
    {
        $user = auth()->user();

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

        if ($user->role_id == 1) {
            session()->flash('success', 'Data lapangan berhasil diubah');
            return redirect()->route('owner.fieldIndex');
        } else if ($user->role_id == 2) {
            session()->flash('success', 'Data lapangan berhasil diubah');
            return redirect()->route('advisor.field');
        }
    }


    public function destroyField($id)
    {
        $user = auth()->user();
        $fieldData = FieldData::find($id);
        if (!$fieldData) {
            session()->flash('error', 'Data lapangan tidak ditemukan');
            return redirect()->back();
        }

        // Hapus file gambar dari penyimpanan
        Storage::disk('public')->delete($fieldData->thumbnail);

        if ($user->role_id == 1) {
            $fieldData->delete();
            session()->flash('success', 'Data lapangan berhasil dihapus');
            return redirect()->route('owner.fieldIndex');
        } else if ($user->role_id == 2) {
            $fieldData->delete();
            session()->flash('success', 'Data lapangan berhasil dihapus');
            return redirect()->route('advisor.field');
        }
    }

    // Field Schedule
    public function indexSchedule()
    {
        $user = auth()->user();
        if ($user->role_id == 1) {
            $fieldSchedule = FieldSchedule::all();
            return view('admin.owner.fields.schedule.index', compact('fieldSchedule'));
        } else if ($user->role_id == 2) {
            return view('admin.advisor.fields.schedule.index');
        }
    }

    public function updateSchedule(Request $request, $id)
    {
        $user = auth()->user();
        $fieldSchedule = FieldSchedule::find($id);

        // Menggunakan operasi ternary untuk menetapkan nilai is_active sesuai dengan checkbox
        $isActive = $request->has('is_active') ? 1 : 0;

        if ($user->role_id == 1) {
            $fieldSchedule->update([
                'is_active' => $isActive,
            ]);
            session()->flash('success', 'Jadwal lapangan berhasil diubah');
            return redirect()->route('owner.scheduleIndex');
        } else if ($user->role_id == 2) {
            session()->flash('success', 'Jadwal lapangan berhasil diubah');
            return redirect()->route('advisor.schedule');
        }
    }

    public function indexScheduleActive()
    {
        $user = auth()->user();

        $scheduleAvailable = ScheduleAvailability::with(['booking', 'fieldData', 'fieldSchedule'])
            ->whereHas('booking', function ($query) {
                $query->where('is_member', 0);
            })
            ->get();
        return view('admin.owner.fields.schedule.scheduleActive', compact('scheduleAvailable'));
    }

    public function destroyScheduleActive(Request $request)
    {
        $ids = $request->input('ids', []);

        // Pastikan $ids adalah array yang valid dan tidak kosong
        if (!is_array($ids) || empty($ids)) {
            return response()->json(['error' => 'Invalid or empty IDs array'], 400);
        }

        try {
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
