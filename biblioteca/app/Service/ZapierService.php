<?php 

namespace App\Service;

use App\Http\Requests\ZapierIntegrationRequest;
use App\Jobs\MakeBookThumbnailFromPDF;
use App\Models\StorageBook;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ZapierService
{
    public function processGoogleDriveUpload(array $uploadedFiles , ZapierIntegrationRequest $request )
    {
        try{
            $entity = $request->createFromRequest();

            $savedFilePath = $this->saveFileToStorage($uploadedFiles);

            $book = $request->createBookFromRequest();
            $entity->appendLog(' | 2-Arquivo salvo com sucesso em: ' . $savedFilePath);

            $bookStorage = StorageBook::create([
                'book_id' => $book->id,
                'storage_path' => $savedFilePath,
            ]);

            if(env('WORK_DISPATCH')??'true' == 'true')
                MakeBookThumbnailFromPDF::dispatchSync($savedFilePath , $book->id);

        }catch(\Exception $e){
            $entity->appendLog(' | Erro ao processar upload do Google Drive: '.$e->getMessage());
            throw $e;
        }

    }

    private function saveFileToStorage(array $uploadedFiles): string
    {
    
        if (empty($uploadedFiles)) 
                throw new \Exception('Nenhum arquivo enviado.');

        // Pega o primeiro arquivo
        $firstFile = reset($uploadedFiles);

        // Lê o conteúdo do arquivo
        $content = file_get_contents($firstFile->getRealPath());

        if (empty($content))
            throw new \Exception('O arquivo está vazio.');

        // Extrai a primeira URL encontrada no conteúdo
        preg_match('/https?:\/\/[^\s]+?(?=\d{4}-\d{2}-\d{2}T|\s|image\/|$)/i', $content, $matches);

        if (!isset($matches[0])) 
            throw new \Exception('Nenhum link encontrado no arquivo.');

        $url = $matches[0];
        $filename = basename(parse_url($url, PHP_URL_PATH));

        // Faz o download do arquivo remoto
        $response = Http::get($url);

        if (!$response->successful())
            throw new \Exception('Falha ao baixar o arquivo remoto.');
            
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        if (empty($extension)) {
            $contentType = $response->header('Content-Type');
            $map = [
                'image/jpeg' => 'jpg',
                'image/png' => 'png',
                'image/gif' => 'gif',
                'application/pdf' => 'pdf',
                'text/plain' => 'txt',
            ];
            $extension = $map[$contentType] ?? 'bin';
            $filename .= '.' . $extension;
        }

        // Salva no storage público
        $path = 'downloads/' . uniqid(pathinfo($filename, PATHINFO_FILENAME) . '_') . '.' . $extension;
        Storage::disk('public')->put($path, $response->body());

        // $publicUrl = Storage::url($path);
        
        return env('FILESYSTEM_PUBLIC_ROOT').'/'.$path;
        // $entity->FileLocation = $path;
        // $entity->appendLog(' | 2-Arquivo salvo com sucesso em: ' . $path.'  '.$publicUrl);
    }
}
