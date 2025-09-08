<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\Image\Enums\ImageDriver;
use Spatie\Image\Image;
use Symfony\Component\Process\Process;

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
        $videoOutputPath = str_replace('.mp4', '_optimized.mp4', $inputPath);
        $imageOutputPath = str_replace('.mp4', '.jpg', $inputPath);
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $ffmpegPath = 'C:\\ffmpeg\\ffmpeg.exe'; // Windows elérési út
        } else {
            $ffmpegPath = 'ffmpeg'; // Linux/Mac elérési út
        }

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
        $process->run();

        

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
        Storage::disk('public')->delete($path);

        //$cmd = "C://ffmpeg.exe -i {$inputPath} -vf scale=1280:720 -c:v libx265 -crf 28 -c:a aac {$videoOutputPath}";
        //$cmd2 = "C://ffmpeg.exe -i {$inputPath} -vf \"select=eq(n\,0)\" -q:v 2 -frames:v 1 {$imageOutputPath}";
        //shell_exec($cmd);
        //shell_exec($cmd2);

    }

}
