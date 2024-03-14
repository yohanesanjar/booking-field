@extends('admin.layouts.main')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Data Lapangan</h1>
    </div>
    {{-- @if (session('error'))
    <div class="alert alert-danger d-flex justify-content-between align-items-center">
        {{ session('error') }}
        <button type="button" class="btn-close flex-end" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif --}}
    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form class="form-card p-4" action="{{ route('owner.fieldStore') }}" method="POST" onsubmit="removeFormattingBeforeSubmit(this)" enctype="multipart/form-data">
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
                            <textarea class="form-control" placeholder="Masukkan Deskripsi Lapangan" id="floatingTextarea2" name="description"
                                style="height: 100px"></textarea>
                            @error('description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row justify-content-between text-left">
                        <div class="form-group col-sm-3 flex-column d-flex">
                            <label class="form-control-label">Jenis Lapangan<span class="text-danger"> *</span></label>
                            <select class="form-select @error('field_type') is-invalid @enderror" aria-label="field_type" id="field_type"
                                name="field_type">
                                <option selected disabled>- Pilih jenis lapangan -</option>
                                <option value="Futsal" {{ old('field_type') == 'Futsal' ? 'selected' : '' }}>Futsal</option>
                                <option value="Bulu Tangkis" {{ old('field_type') == 'Bulu Tangkis' ? 'selected' : '' }}>Bulu Tangkis</option>
                            </select>
                            @error('field_type')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-sm-3 flex-column d-flex">
                            <label class="form-control-label">Material Lapangan<span class="text-danger"> *</span></label>
                            <select class="form-select @error('field_material') is-invalid @enderror" aria-label="field_material" id="field_material"
                                name="field_material">
                                <option selected disabled>- Pilih material lapangan -</option>
                                <option value="Plur" {{ old('field_material') == 'Plur' ? 'selected' : '' }}>Plur</option>
                                <option value="Vinyl" {{ old('field_material') == 'Vinyl' ? 'selected' : '' }}>Vinyl</option>
                                <option value="Rumput Sintetis" {{ old('field_material') == 'Rumput Sintetis' ? 'selected' : '' }}>Rumput Sintetis</option>
                                <option value="Parquette" {{ old('field_material') == 'Parquette' ? 'selected' : '' }}>Parquette</option>
                            </select>
                            @error('field_material')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-sm-3 flex-column d-flex">
                            <label class="form-control-label">Lokasi Lapangan<span class="text-danger"> *</span></label>
                            <select class="form-select @error('field_location') is-invalid @enderror" aria-label="field_location" id="field_location"
                                name="field_location">
                                <option selected disabled>- Pilih lokasi lapangan -</option>
                                <option value="Indoor" {{ old('field_location') == 'Indoor' ? 'selected' : '' }}>Indoor</option>
                                <option value="Outdoor" {{ old('field_location') == 'Outdoor' ? 'selected' : '' }}>Outdoor</option>
                            </select>
                            @error('field_location')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-sm-3 flex-column d-flex">
                            <label class="form-control-label">Harga<span class="text-danger"> *</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="text" id="price" name="price" class="form-control" placeholder="Masukkan Harga" oninput="formatCurrency(this)">
                            </div>
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

    <script>
        function formatCurrency(input) {
            // Remove non-numeric characters
            let numericValue = input.value.replace(/[^0-9]/g, '');
    
            // Format the value with commas for thousands
            let formattedValue = new Intl.NumberFormat('id-ID').format(numericValue);
    
            // Add the "Rp" prefix
            formattedValue = formattedValue;
    
            // Update the input value
            input.value = formattedValue;
        }
    
        // Remove formatting before submitting the form
        function removeFormattingBeforeSubmit(form) {
            let priceInput = form.elements['price'];
            priceInput.value = priceInput.value.replace(/[^0-9]/g, '');
        }
    </script>        
@endsection
