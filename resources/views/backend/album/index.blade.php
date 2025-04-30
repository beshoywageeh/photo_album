@extends('layout.master')
@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="card-title"> Album List</h5>
        <a href="{{ route('album.create') }}" class="btn btn-primary">Create New Album</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped text-center">
                <tr>
                    <th>#</th>
                    <th>Album Title</th>
                    <th>Images Count</th>
                    <th>Action</th>
                </tr>
                @forelse ($data as $album )
        
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>
                        {{ $album->name }}
                    </td>
                    <td>
                        {{ $album->image_count }}
                    </td>
                    <td>
                       <a class="btn btn-warning" href="{{ route('album.edit',$album->id) }}">Edit</a>
                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete_album_{{$album->id}}">delete</button>
                    </td>
                </tr>
                @include('backend.album.delete')
                @empty
                    <tr>
                        <td colspan="4" class="alert alert-info text-center">
                            No Albums To Show
                        </td>
                    </tr>
                @endforelse
            </table>
        
        </div>
        <div>
            {{ $data->links() }}
        </div>
    </div>
</div>

@endsection