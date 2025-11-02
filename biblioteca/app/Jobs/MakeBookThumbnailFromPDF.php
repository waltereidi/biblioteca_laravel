<?php

namespace App\Jobs;
use App\Models\Log_ImagickJob;
use App\Models\StorageBookThumbnail;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
class MakeBookThumbnailFromPDF implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $sourcePath;
    private ?string $targetPath;
    private int $book_id;
    /**
     * Create a new job instance.
     */
    public function __construct(string $sourcePath, int $book_id)
    {
        $this->sourcePath = $sourcePath;
        $this->targetPath = $targetPath ?? env('FILESYSTEM_TEMP').'/' ?? throw new Exception("Unset temporary folder in .env"); // sobrescreve se não passar
        $this->book_id = $book_id ?? throw new Exception("Book ID is required");
    }
    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log_ImagickJob::create([
            'description' => 'Iniciando processamento de thumbnail para PDF: ' . $this->sourcePath .$this->targetPath,
            'severity' => 'info'
        ]);
        

        try{
            $saveThumnailPath = $this->targetPath . '/sample_cover_thumbnail.jpg';

            $imagick = new \Imagick();
            $imagick->setResolution(150, 150);


            $imagick->readImage("{$this->sourcePath}[0]");
            $imagick->setImageFormat('jpeg');
            $imagick->setImageBackgroundColor('white');
            $imagick = $imagick->mergeImageLayers(\Imagick::LAYERMETHOD_FLATTEN);

            // 4️⃣ Redimensiona mantendo proporção
            $imagick->thumbnailImage(300, 300, true);

            // 5️⃣ Salva no diretório de teste do Laravel
            $imagick->writeImage($saveThumnailPath);
            $path = 'thumnail/' . uniqid() . '.' . 'jpg';
            
            Storage::disk('public')->put($path, File::get($saveThumnailPath));
            
            Log_ImagickJob::create([
                    'description' => 'Thumbnail salvo em' . $path,
                    'severity' => '0'
                ]);


            $bookStorageThumbnail = StorageBookThumbnail::create([
                    'book_id' => $this->book_id,
                    'storage_path' =>env('FILESYSTEM_PUBLIC_ROOT').$path,
                ]);

            $imagick->clear();
            $imagick->destroy();

        }catch(Exception $e){
            Log_ImagickJob::create([
                'description' => 'Erro ao gerar thumbnail para PDF: ' . $this->sourcePath . ' - ' . $e->getMessage(),
                'severity' => '5'
            ]);
        }   
        
    }
}
