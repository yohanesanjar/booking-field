@extends('admin.layouts.main')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Data Postingan</h1>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form class="form-card p-4" action="{{ route('owner.postUpdate', $post->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    <div class="row justify-content-between text-left">
                        <div class="form-group col-12 flex-column d-flex">
                            <label class="form-control-label">Judul<span class="text-danger"> *</span>
                            </label>
                            <input type="text" id="title" name="title" value="{{ $post->title }}"
                                placeholder="Masukkan Judul Postingan">
                            @error('title')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row justify-content-between text-left">
                        <div class="form-group col-sm-3 flex-column d-flex">
                            <label class="form-control-label">Kategori<span class="text-danger"> *</span></label>
                            <select class="form-select @error('category') is-invalid @enderror" aria-label="category"
                                id="category" name="category">
                                <option selected disabled>- Pilih kategori -</option>
                                <option value="Article" {{ $post->category == 'Artikel' ? 'selected' : '' }}>Artikel
                                </option>
                                <option value="Informasi" {{ $post->category == 'Informasi' ? 'selected' : '' }}>
                                    Informasi
                                </option>
                            </select>
                            @error('category')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row justify-content-between text-left">
                        <div class="form-group col-12 flex-column d-flex">
                            <label class="form-control-label">Deskripsi<span class="text-danger"> *</span>
                            </label>
                            <textarea name="description" id="description" cols="30" rows="10">{{ $post->description }}</textarea>
                            @error('account_number')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row justify-content-between text-left">
                        <div class="form-group col-12 flex-column d-flex">
                            <label class="form-control-label">Thumbnail<span class="text-danger"> *</span>
                            </label>
                            <!-- Image preview -->
                            <div class="preview py-3 text-center">
                                <img id="thumbnail-preview" src="{{ asset('storage/' . $post->thumbnail) }}"
                                    alt="Current Thumbnail" style="width: 400px;">
                            </div>
                            <input class="form-control" type="file" name="thumbnail" id="thumbnail"
                                onchange="previewThumbnail(this)">
                            @error('thumbnail')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row justify-content-end py-4 px-4">
                        <div class="form-group col-sm-2">
                            <button type="submit" class="btn-block btn-primary">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $('#description').summernote({
            placeholder: 'Masukkan Deskripsi',
            tabsize: 2,
            height: 300,
        });
    </script>
    <script>
        // Function to preview the selected image
        function previewThumbnail(input) {
            var preview = document.getElementById('thumbnail-preview');

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
