<?php

namespace App\Jobs;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
class GetThumbnailFromPDF implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $sourcePath;
    public ?string $targetPath;
    /**
     * Create a new job instance.
     */
    public function __construct(string $sourcePath, ?string $targetPath = null)
    {
        $this->sourcePath = $sourcePath;
        $this->targetPath = $targetPath ?? $sourcePath; // sobrescreve se não passar
    }
    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // aqui vamos usar Imagick
        $image = new \Imagick($this->sourcePath);

        // exemplo: redimensionar para 1024 de largura mantendo proporção
        $image->resizeImage(1024, 0, \Imagick::FILTER_LANCZOS, 1);

        // otimizar um pouco
        $image->setImageCompression(\Imagick::COMPRESSION_JPEG);
        $image->setImageCompressionQuality(85);

        // salva
        $image->writeImage($this->targetPath);

        $image->clear();
        $image->destroy();
    }
}
