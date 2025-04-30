@extends('layout.master')

@section('content')
    <div class="container mt-4">
        <h2>Edit Album</h2>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('album.update', $album->id) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="mb-3 col-md-6">
                <label for="album_name" class="form-label">Album Name</label>
                <input type="text" class="form-control" name="album_name" value="{{ old('album_name', $album->name) }}"
                    required>
                @error('album_name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-6">
                <label for="files" class="form-label">Upload Images</label>
                <input type="file" name="files[]" id="imageInput" class="form-control" multiple accept="image/*"
                    onchange="previewImages(event)">
                @error('files')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
                <!-- Preview container for new images -->
                <div id="imagePreview" class="mt-3 row"></div>
                </div>
            </div>

            <div class="mb-3">
                <h5>Existing Images</h5>
                <div class="row">
                    @foreach($album->image as $image)
                        <div class="mb-2 col-md-3">
                            <div class="card">
                                <img src="{{ asset('storage/albums/' . $album->name . '/' . $image->filename) }}" class="card-img-top" alt="{{ $image->filename }}">
                                <div class="card-body">
                                    <p class="card-text">{{ $image->filename }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Update Album</button>
            <a href="{{ route('album.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <script>
    function previewImages(event) {
        const imagePreview = document.getElementById('imagePreview');
        imagePreview.innerHTML = ''; // Clear previous previews

        const files = event.target.files;
        for(let i = 0; i < files.length; i++) {
            const file = files[i];
            if(!file.type.startsWith('image/')){ continue; }

            const col = document.createElement('div');
            col.className = 'col-md-3 mb-2';

            const card = document.createElement('div');
            card.className = 'card';

            const img = document.createElement('img');
            img.className = 'card-img-top';
            img.style.height = '200px';
            img.style.objectFit = 'cover';

            const reader = new FileReader();
            reader.onload = (e) => {
                img.src = e.target.result;
            };
            reader.readAsDataURL(file);

            const cardBody = document.createElement('div');
            cardBody.className = 'card-body';
            cardBody.innerHTML = `<p class="card-text">${file.name}</p>`;

            card.appendChild(img);
            card.appendChild(cardBody);
            col.appendChild(card);
            imagePreview.appendChild(col);
        }
    }
    </script>
@endsection
