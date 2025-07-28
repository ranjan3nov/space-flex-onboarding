<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;

class ImageHelper
{
    /**
     * Upload an image and return the storage path.
     *
     * @param UploadedFile $file
     * @param string $directory
     * @return string
     */
    public static function upload(UploadedFile $file, $directory = 'images')
    {
        return $file->store($directory, 'public');
    }
}
