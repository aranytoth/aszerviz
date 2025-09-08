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
        ->width(1280)
        ->optimize()
        ->save(storage_path('app/public/'.$this->id.'/company/'. $this->$attributeName));
        Storage::delete(storage_path('app/public/temp/' . $this->$attributeName));
        $this->$attributeName = asset('storage/'.$this->id.'/company/'. $this->$attributeName);
    }

    public function storeWorksheetImage()
    {
        $attributeName = $this->uploadImageName;
        Storage::disk('public')->makeDirectory(date('Y/m/d'));
         if($this->has_video == 'true'){
            $this->$attributeName = str_replace('.mp4', '.jpg', $this->$attributeName);
            $videoOutputPath = str_replace('.jpg', '_optimized.mp4', $this->$attributeName);
            Storage::disk('public')->move('temp/' . $videoOutputPath, date('Y/m/d/'). $videoOutputPath);
            
        }

        Image::useImageDriver(ImageDriver::Gd)
        ->loadFile(storage_path('app/public/temp/' . $this->$attributeName))
        ->width(800)
        ->optimize()
        ->save(storage_path('app/public/'.date('Y/m/d/'). $this->$attributeName));
        Storage::delete(storage_path('app/public/temp/' . $this->$attributeName));
        
        $this->$attributeName = asset('storage/'.date('Y/m/d/'). $this->$attributeName);
    }
}