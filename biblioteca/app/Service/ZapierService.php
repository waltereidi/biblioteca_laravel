<?php 

namespace App\Service;

use App\Models\ZapierIntegration;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ZapierService
{
    public function processGoogleDriveUpload(array $uploadedFiles , ZapierIntegration $entity)
    {
        if (empty($uploadedFiles)) {
            $entity->appendLog(' | 2-Erro ao salvar arquivo: nenhum arquivo encontrado.');
            return response()->json(['error' => 'Nenhum arquivo enviado.'], 400);
        }

        // Pega o primeiro arquivo
        $firstFile = reset($uploadedFiles);

        // Lê o conteúdo do arquivo
        $content = file_get_contents($firstFile->getRealPath());

        if (empty($content)) {
            $entity->appendLog(' | 2-Erro ao salvar arquivo: arquivo vazio.');
            return response()->json(['error' => 'O arquivo está vazio.'], 400);
        }

        // Extrai a primeira URL encontrada no conteúdo
        preg_match('/https?:\/\/[^\s]+/i', $content, $matches);

        if (!isset($matches[0])) {
            $entity->appendLog(' | 2-Erro ao salvar arquivo: nenhum link encontrado no arquivo.');
            return response()->json(['error' => 'Nenhum link encontrado no arquivo.'], 400);
        }

        $url = $matches[0];
        $filename = basename(parse_url($url, PHP_URL_PATH));

        // Faz o download do arquivo remoto
        $response = Http::get($url);

        if (!$response->successful()) {
            $entity->appendLog(' | 2-Erro ao baixar o arquivo remoto.');
            return response()->json(['error' => 'Falha ao baixar o arquivo remoto.'], 500);
        }

        // Salva no storage público
        $path = 'downloads/' . $filename;
        Storage::disk('public')->put($path, $response->body());

        $publicUrl = Storage::url($path);
        $entity->FileLocation = $path;
        $entity->appendLog(' | 2-Arquivo salvo com sucesso em: ' . $path.'  '.$publicUrl);

        return response()->json([
            'success' => true,
            'source_url' => $url,
            'file_name' => $filename,
            'storage_path' => $path,
            'public_url' => $publicUrl,
        ]);

    }
    

}
