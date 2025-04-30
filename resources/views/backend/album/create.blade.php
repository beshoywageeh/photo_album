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
                <input class="form-control" type="file" name="files[]" multiple accept="images">
            </div>
        </div>
    </form>
</div>

@endsection