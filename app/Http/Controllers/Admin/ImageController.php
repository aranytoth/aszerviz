<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\Image\Enums\ImageDriver;
use Spatie\Image\Image;
use Symfony\Component\Process\Process;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ImageController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|mimes:mp4,mov,ogg,qt,jpg,jpeg,webp,webm',
        ]);

        $uploadedFile = $request->file('image');
        $video = false;
        
        $path = $uploadedFile->store('temp', ['disk' => 'public']);

        if($this->str_contains_any($uploadedFile->getMimeType(), ['mp4', 'mov', 'ogg', 'qt', 'webm'])){
           
           $this->optimizeVideo(Storage::disk('public')->path($path), $path);
           $path = str_replace('.mp4', '.jpg', $path);
           $video = true;
        }
        
        return [
            'path' => '/storage/'.$path,
            'video' => $video,
            'filename' => $uploadedFile->hashName()
        ];
    }

    public static function store($path, $finalPath)
    {
        Image::useImageDriver(ImageDriver::Gd)->loadFile(storage_path('app/' . $path))
        ->width(800)
        ->save(storage_path('app/public/' . $finalPath));
    }

    private function str_contains_any(string $haystack, array $needles): bool
    {
        return array_reduce($needles, fn($a, $n) => $a || str_contains($haystack, $n), false);
    }

    public function optimizeVideo($inputPath, $path)
    {

         if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $ffmpegPath = 'C:\\ffmpeg\\ffmpeg.exe'; // Windows elérési út
            } else {
                $ffmpegPath = 'ffmpeg'; // Linux/Mac elérési út
            }
        $imageOutputPath = str_replace('.mp4', '.jpg', $inputPath);
        /*$videoOutputPath = str_replace('.mp4', '_optimized.mp4', $inputPath);
        

        $process = new Process([
            $ffmpegPath,
            '-i', $inputPath,
            '-vf', 'scale=1280:720',
            '-c:v', 'libx265',
            '-crf', '28',
            '-c:a', 'aac',
            $videoOutputPath
        ]);

        $process->setTimeout(60);
        $process->run();*/

        $process2 = new Process([
            $ffmpegPath,
            '-i', $inputPath,
            '-vf', 'select=eq(n\\,0)',
            '-q:v', '2',
            '-frames:v', '1',
            $imageOutputPath
        ]);

        $process2->setTimeout(60);
        $process2->run();
        //Storage::disk('public')->delete($path);

        //$cmd = "C://ffmpeg.exe -i {$inputPath} -vf scale=1280:720 -c:v libx265 -crf 28 -c:a aac {$videoOutputPath}";
        //$cmd2 = "C://ffmpeg.exe -i {$inputPath} -vf \"select=eq(n\,0)\" -q:v 2 -frames:v 1 {$imageOutputPath}";
        //shell_exec($cmd);
        //shell_exec($cmd2);

    }

    /**
     * Kép átméretezése és cache-elése.
     * * ARCHITECTURAL DECISION:
     * Bár a projektben elérhető lehet más képkezelő (pl. Spatie Image),
     * szándékosan az Intervention Image-et használjuk itt.
     * * OK: Ez egy dobozos termék, és nem garantálhatjuk, hogy a végfelhasználó
     * szerverén telepítve van az ImageMagick (amit a Spatie Image v3+ hard dependency-ként kezel jelenleg).
     * Az Intervention megbízhatóan működik a standard GD könyvtárral is, ami
     * szinte minden PHP környezetben alapértelmezett.
     * * @see https://image.intervention.io/
    */
    public function resize($folder_id, $dimensions, $filename)
    {
        $newDimensions = explode('x',$dimensions);
        $file = Storage::disk('public')->path($folder_id.'/'.$filename);

        if(!file_exists($file)){
            abort(404);
        }

        $manager = new ImageManager(Driver::class);
        $image = $manager->read($file);
        $image->cover($newDimensions[0], $newDimensions[1]);
        Storage::disk('public')->makeDirectory($folder_id.'/'.$dimensions);
        $image->save(Storage::disk('public')->path($folder_id.'/'.$dimensions.'/'.$filename));

        //$image = Image::load($file)
        //->fit(fit: Fit::FillMax, desiredWidth:  $newDimensions[0],  desiredHeight: $newDimensions[1])
        //->save(Storage::disk('public')->path($folder_id.'/'.$dimensions.'/'.$filename));

        return response()->file(Storage::disk('public')->path($folder_id.'/'.$dimensions.'/'.$filename));
    }

}
