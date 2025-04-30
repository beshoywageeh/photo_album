<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\album;
use App\Http\Traits\ImageTrait;

class AlbumController extends Controller
{
    use ImageTrait;
    public function index()
    {
        $data = album::where('user_id',auth()->user()->id)->withCount('image')->paginate('10');

        return view('backend.album.index', compact('data'));
    }
    public function create()
    {
        return view('backend.album.create');
    }
    public function store(Request $request)
    {
        try {
            \DB::beginTransaction();
            $album = album::create([
                'name' => $request->album_name,
                'user_id' => auth()->user()->id
            ]);
            $this->verifyAndStoreImage($request, 'files', '//albums/'.$album->name, 'public', $album->id, 'App\Models\album');
            \DB::commit();
            return redirect()->route('album.index');
        } catch (\Exception $e) {
            \DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }



    public function edit($id)
    {
        // Find the album by its ID
        $album = album::find($id);

        // Ensure the album exists
        if (!$album) {
            session()->flash('error', 'Album not found!');
            return redirect()->route('album.index');
        }

        // Return the edit view with the album data
        return view('backend.album.edit', compact('album'));
    }

    /**
     * Update the specified album in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Album  $album
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // Find the album by its ID
        $album = album::find($id);

        // Ensure the album exists
        if (!$album) {
            session()->flash('error', 'Album not found!');
            return redirect()->route('album.index');
        }

        try {
            \DB::beginTransaction();

            // Update the album name
            $album->name = $request->album_name;
            $album->save();

            // Check if new images were uploaded and handle them
            if ($request->hasFile('files')) {
                // Here, we call the verifyAndStoreImage method from ImageTrait
                // to store the new images in the album
                $this->verifyAndStoreImage($request, 'files', '//albums/'.$album->name, 'public', $album->id, 'App\Models\album');
            }

            \DB::commit();

            // Success message
            session()->flash('success', 'Album updated successfully!');

            return redirect()->route('album.index');
        } catch (\Exception $e) {
            \DB::rollback();
            session()->flash('error', 'Error updating album: ' . $e->getMessage());
            return redirect()->back();
        }
    }



    
    public function destroy(Request $request){
        $data = album::find($request->id);
        $data->delete();
        return redirect()->route('album.index');

    } 
    public function destroy_transfer(Request $request)
{
    // Find the old album (the one to be deleted)
    $oldAlbum = album::find($request->id);

    // Ensure the old album exists
    if (!$oldAlbum) {
        session()->flash('error', 'Old album not found!');
        return redirect()->back();
    }

    // Get the new album where the images should be transferred
    $newAlbum = album::find($request->new_album);

    // Ensure the new album exists
    if (!$newAlbum) {
        session()->flash('error', 'New album not found!');
        return redirect()->back();
    }

    // Transfer images to the new album
    foreach ($oldAlbum->image as $image) {
        // Transfer each image to the new album
        $this->transferImage($image, $newAlbum,$oldAlbum->name);
    }

    // After transferring images, delete the old album
    $oldAlbum->delete();

    // Success message
    session()->flash('success', 'Album and images transferred successfully!');

    return redirect()->route('album.index');
}

/**
 * Handle transferring an image from the old album to the new album.
 *
 * @param  \App\Models\Image  $image
 * @param  \App\Models\album  $newAlbum
 * @return void
 */
protected function transferImage($image, $newAlbum,$oldname)
{
    // Update the image to belong to the new album
    $image->imageable_id = $newAlbum->id;
    $image->imageable_type = 'App\Models\album';
    $image->save();

    // Optionally, you could also change the image filename or move the file on the disk if needed

    // Store the image in the new album directory (using the new album's name)
    $newPath = \Storage::disk('public')->move(
        'albums/'.$oldname .'/'. $image->filename,
        'albums/' . $newAlbum->name . '/' . $image->filename
    );

    // If you're using a new directory structure, you might want to rename the image path
    $image->filename = $newAlbum->name . '/' . $image->filename;
    $image->save();

    // Optionally, you could delete the old image file if necessary
    // Storage::disk('public')->delete('albums/' . $image->filename);
}

}