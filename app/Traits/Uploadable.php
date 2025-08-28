<?php 

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Spatie\Image\Enums\ImageDriver;
use Spatie\Image\Image;

trait Uploadable {

    public $uploadImageName = 'image';

    public function storeImage()
    {
        $attributeName = $this->uploadImageName;
        Storage::disk('public')->makeDirectory($this->id.'/company/');
        Image::useImageDriver(ImageDriver::Gd)
        ->loadFile(storage_path('app/public/temp/' . $this->$attributeName))
        ->width(800)
        ->optimize()
        ->save(storage_path('app/public/'.$this->id.'/company/'. $this->$attributeName));

        $this->$attributeName = asset('storage/'.$this->id.'/company/'. $this->$attributeName);
    }

    public function storeWorksheetImage()
    {
        $attributeName = $this->uploadImageName;
        Storage::disk('public')->makeDirectory(date('Y/m/d'));
        Image::useImageDriver(ImageDriver::Gd)
        ->loadFile(storage_path('app/public/temp/' . $this->$attributeName))
        ->width(800)
        ->optimize()
        ->save(storage_path('app/public/'.date('Y/m/d/'). $this->$attributeName));

        $this->$attributeName = asset('storage/'.date('Y/m/d/'). $this->$attributeName);
    }
}