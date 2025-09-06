<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Image\Enums\ImageDriver;
use Spatie\Image\Image;

class ImageController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|mimes:mp4,mov,ogg,qt,jpg,jpeg,webp,webm',
        ]);

        $uploadedFile = $request->file('image');


        $path = $uploadedFile->store('temp', ['disk' => 'public']);

        return [
            'path' => '/storage/'.$path,
            'filename' => $uploadedFile->hashName()
        ];
    }

    public static function store($path, $finalPath)
    {
        Image::useImageDriver(ImageDriver::Gd)->loadFile(storage_path('app/' . $path))
        ->width(800)
        ->save(storage_path('app/public/' . $finalPath));
    }
}
