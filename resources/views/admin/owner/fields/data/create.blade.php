@extends('admin.layouts.main')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Lapangan</h1>
    </div>
    @if (session('error'))
        <div class="alert alert-success">
            {{ session('error') }}
        </div>
    @endif
    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form class="form-card p-4" action="{{ route('owner.fieldStore') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row justify-content-between text-left">
                        <div class="form-group col-12 flex-column d-flex">
                            <label class="form-control-label">Nama Lapangan<span class="text-danger"> *</span>
                            </label>
                            <input type="text" id="name" name="name" placeholder="Masukkan Nama Lapangan">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row justify-content-between text-left">
                        <div class="form-group col-12 flex-column d-flex">
                            <label class="form-control-label">Deskripsi Lapangan<span class="text-danger"> *</span>
                            </label>
                            <textarea class="form-control" placeholder="Masukkan Deskripsi Lapangan" id="floatingTextarea2" name="description" style="height: 100px"></textarea>
                            @error('description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row justify-content-between text-left">
                        <div class="form-group col-sm-3 flex-column d-flex">
                            <label class="form-control-label">Jenis Lapangan<span class="text-danger"> *</span></label>
                            <input type="text" id="field_type" name="field_type" placeholder="Masukkan Jenis Lapangan">
                            @error('field_type')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-sm-3 flex-column d-flex">
                            <label class="form-control-label">Material Lapangan<span class="text-danger"> *</span></label>
                            <input type="text" id="field_material" name="field_material"
                                placeholder="Masukkan Material Lapangan">
                            @error('field_material')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-sm-3 flex-column d-flex">
                            <label class="form-control-label">Lokasi Lapangan<span class="text-danger"> *</span></label>
                            <input type="text" id="field_location" name="field_location"
                                placeholder="Masukkan Lokasi Lapangan">
                            @error('field_location')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-sm-3 flex-column d-flex">
                            <label class="form-control-label">Harga<span class="text-danger"> *</span></label>
                            <input type="number" id="field_material" name="price" placeholder="Masukkan Harga">
                            @error('price')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row justify-content-between text-left">
                        <div class="form-group col-12 flex-column d-flex">
                            <label class="form-control-label">Thumbnail<span class="text-danger"> *</span>
                            </label>
                            <input class="form-control" type="file" name="thumbnail" id="thumbnail">
                            @error('thumbnail')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row justify-content-end py-4 px-4">
                        <div class="form-group col-sm-2">
                            <button type="submit" class="btn-block btn-primary">Create</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
