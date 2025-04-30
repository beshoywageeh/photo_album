<?php

namespace App\Http\Traits;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait ImageTrait
{
    /**
     * Validate and store multiple images.
     *
     * @param  string  $inputName
     * @param  string  $folderName
     * @param  string  $disk
     * @param  int  $imageableId
     * @param  string  $imageableType
     * @param  Image|null  $existingImage
     * @return array|null
     */
    public function verifyAndStoreImage(Request $request, string $inputName, string $folderName, string $disk, int $imageableId, string $imageableType, ?Image $existingImage = null): ?array
    {
        if (!$request->hasFile($inputName)) {
            return null;
        }

        $photos = $request->file($inputName);
        $storedPaths = [];

        foreach ($photos as $photo) {
            $validationResult = $this->validateImage($photo);

            if ($validationResult !== true) {
                flash()->addError($validationResult)->important();
                return redirect()->back()->withInput();
            }

            $filename = $this->generateFileName($photo);
            $storedPath = $this->storeImage($photo, $filename, $folderName, $disk, $existingImage, $imageableId, $imageableType);

            if ($storedPath) {
                $storedPaths[] = $storedPath;
            }
        }

        return $storedPaths;
    }

    /**
     * Validate the image file.
     *
     * @param  \Illuminate\Http\UploadedFile  $photo
     * @return bool|string
     */
    protected function validateImage($photo)
    {
        $validExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        $maxSize = 5 * 1024 * 1024; // 5MB

        if (!in_array($photo->getClientOriginalExtension(), $validExtensions)) {
            return 'Invalid image type. Only jpg, jpeg, png, and gif are allowed.';
        }

        if ($photo->getSize() > $maxSize) {
            return 'The image is too large. Maximum size allowed is 5MB.';
        }

        return true;
    }

    /**
     * Generate a unique filename for the image.
     *
     * @param  \Illuminate\Http\UploadedFile  $photo
     * @return string
     */
    protected function generateFileName($photo): string
    {
        $name = $photo->getClientOriginalName();
        return Str::slug(pathinfo($name, PATHINFO_FILENAME)) . '-' . now()->timestamp . '.' . $photo->getClientOriginalExtension();
    }

    /**
     * Store the image and update or create the image record.
     *
     * @param  \Illuminate\Http\UploadedFile  $photo
     * @param  string  $filename
     * @param  string  $folderName
     * @param  string  $disk
     * @param  Image|null  $existingImage
     * @param  int  $imageableId
     * @param  string  $imageableType
     * @return string|null
     */
    protected function storeImage($photo, string $filename, string $folderName, string $disk, ?Image $existingImage, int $imageableId, string $imageableType): ?string
    {
        // Delete existing image if applicable
        if ($existingImage) {
            Storage::disk($disk)->delete($folderName . '/' . $existingImage->filename);
            $existingImage->filename = $filename;
            $existingImage->save();
        } else {
            $newImage = new Image;
            $newImage->filename = $filename;
            $newImage->imageable_id = $imageableId;
            $newImage->imageable_type = $imageableType;
            $newImage->save();
        }

        // Store the image and return the path
        return $photo->storeAs($folderName, $filename, $disk);
    }
}
