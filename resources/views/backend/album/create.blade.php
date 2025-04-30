@extends('layout.master')
@section('content')
<div class="card">
    <form method="post" action="{{ route('album.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="card-header">
            <h5 class="card-title"> Create New Album</h5>
            <button type="submit" class="btn btn-primary">Store</button>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label>Album Name</label>
                <input class="form-control" type="string" name="album_name">
            </div>
            <div class="form-group">
                <label>Select Images</label>
                <input class="form-control" type="file" name="files[]" multiple accept="image/*" id="imageInput">
            </div>
            <div id="preview" class="flex-wrap mt-3 d-flex"></div>
        </div>
    </form>
</div>

<script>
    document.getElementById('imageInput').addEventListener('change', function(event) {
        const preview = document.getElementById('preview');
        preview.innerHTML = ''; // Clear previous thumbnails
        const files = event.target.files;

        Array.from(files).forEach(file => {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.width = '100px';
                    img.style.height = '100px';
                    img.style.objectFit = 'cover';
                    img.style.margin = '5px';
                    preview.appendChild(img);
                };
                reader.readAsDataURL(file);
            }
        });
    });
</script>
@endsection