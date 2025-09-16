<?php

namespace App\Jobs;

use App\Models\WorksheetImage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;

class OptimizeVideo implements ShouldQueue
{
    use Queueable;

    public $videoPath;

    /**
     * Create a new job instance.
     */
    public function __construct($videoPath)
    {
        $this->videoPath = $videoPath;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        echo $this->videoPath.PHP_EOL;
        $videoOutputPath = str_replace('.mp4', '_optimized.mp4', $this->videoPath);
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $ffmpegPath = 'C:\\ffmpeg\\ffmpeg.exe'; // Windows elérési út
        } else {
            $ffmpegPath = 'ffmpeg'; // Linux/Mac elérési út
        }

        $process = new Process([
            $ffmpegPath,
            '-i', $this->videoPath,
            '-vf', 'scale=1280:720',
            '-c:v', 'libx265',
            '-crf', '28',
            '-c:a', 'aac',
            $videoOutputPath
        ]);

        $process->setTimeout(900);
        $result = $process->run();

        if ($process->isSuccessful()) {
            Storage::disk('public')->delete($this->videoPath);
            rename($videoOutputPath, $this->videoPath);
        }

    }
}
