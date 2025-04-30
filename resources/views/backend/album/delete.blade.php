<div class="modal fade" id="delete_album_{{ $album->id }}" tabindex="-1"
    aria-labelledby="delete_album_label_{{ $album->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title fs-5" id="delete_album_label_{{ $album->id }}">Are You sure to Delete Album</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
            </div>
            <form action="{{ route('album.destroy') }}" method="POST">
                <div class="modal-body">
                    <h5> Delete Album With Images</h5>
                    @csrf
                    <input type="hidden" value="{{ $album->id }}" name="id">
                    <input type="text" readonly value="{{ $album->name }}" class="form-control">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">delete</button>
                </div>
            </form>
            <hr>

            @if ($album->image_count != 0)
                <form action="{{ route('album.destroy_transfer') }}" method="POST">
                    <div class="modal-body">
                        <h5> Delete Album And Transfer With Images</h5>
                        @csrf
                        <input type="hidden" value="{{ $album->id }}" name="id">
                        <input type="text" readonly value="{{ $album->name }}" class="form-control">
                        <label>Transfer To anthoer Album </label>
                        <select class="form-control" name="new_album">
                            @foreach ($data as $album)
                                <option value="{{ $album->id }}">{{ $album->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">transfer delete</button>
                    </div>
                </form>
            @endif
        </div>
    </div>
</div>
