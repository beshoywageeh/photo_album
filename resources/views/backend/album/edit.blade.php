@extends('layout.master')

@section('content')
<div class="container mt-4">
    <h2>Edit Album</h2>

    {{-- Display Success or Error Messages --}}
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

    {{-- Edit Album Form --}}
    <form action="{{ route('album.update', $album->id) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <!-- Album Name Input -->
            <div class="mb-3 col-md-6">
                <label for="album_name" class="form-label">Album Name</label>
                <input type="text" class="form-control" name="album_name" value="{{ old('album_name', $album->name) }}" required>
                @error('album_name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Images Upload Input -->
            <div class="mb-3 col-md-6">
                <label for="files" class="form-label">Upload Images</label>
                <input type="file" name="files[]" class="form-control" multiple>
                @error('files')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Display Existing Images (Optional) --}}
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
@endsection
