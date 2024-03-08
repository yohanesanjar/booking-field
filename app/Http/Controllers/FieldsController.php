<?php

namespace App\Http\Controllers;

use App\Models\FieldData;
use Illuminate\Http\Request;

class FieldsController extends Controller
{
    public function indexField()
    {
        return view('admin.owner.fields.data.index');
    }

    public function createField()
    {
        return view('admin.owner.fields.data.create');
    }

    public function storeField(Request $request)
    {
        $user = auth()->user();

        try {
            $request->validate([
                'name' => 'required',
                'description' => 'required',
                'field_type' => 'required',
                'field_material' => 'required',
                'field_location' => 'required',
                'price' => 'required',
                'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust the validation rules as needed
            ]);

            $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public'); // Assuming 'thumbnails' is the storage folder

            FieldData::create([
                'name' => $request->name,
                'description' => $request->description,
                'field_type' => $request->field_type,
                'field_material' => $request->field_material,
                'field_location' => $request->field_location,
                'price' => $request->price,
                'thumbnail' => $thumbnailPath,
            ]);

            if ($user->role_id == 1) {
                session()->flash('success', 'Data lapangan berhasil ditambahkan');
                return redirect()->route('owner.field');
            } else if ($user->role_id == 2) {
                session()->flash('success', 'Data lapangan berhasil ditambahkan');
                return redirect()->route('advisor.field');
            }
        } catch (\Exception $e) {
            // Handle the exception, e.g., log the error
            session()->flash('error', 'Tidak bisa menambahkan data. Tolong coba lagi.');
            return redirect()->back()->withInput()->withErrors(['error_message' => 'Tidak bisa menambahkan data. Tolong coba lagi.']);
        }
    }
}
