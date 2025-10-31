<?php

namespace App\Http\Controllers;

use App\Models\ZapierIntegration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ZapierController extends Controller
{
    /**
     * Recebe uma requisição POST enviada pelo Zapier.
     */
    public function googleDriveFileUpload(Request $request)
    {
        // Remove o campo 'file' do payload
        $data = $request->except('file'); 

        // Cria a entidade base
        $entity = new ZapierIntegration();
        $entity->NomeIntegracao = 'ZapierGoogleDriveAPI';
        $entity->Evento = $request->input('event', 'unknown');
        $entity->Payload = $data;
        $entity->Ativo = true;
        $entity->DataRecebimento = now();
        $entity->appendLog('1-Recebido requisição de : '.$request->ip());

        // Captura o primeiro arquivo enviado (independente do nome do campo)
        $uploadedFiles = $request->allFiles();
        $firstFile = reset($uploadedFiles); // pega o primeiro arquivo

        if ($firstFile) {
            // Nome do arquivo definido no JSON (campo 'originalFilename')
            $originalName = $request->input('originalFilename', $firstFile->getClientOriginalName());

            // Salva o arquivo com o nome original dentro de storage/livros/
            $path = $firstFile->storeAs('livros', $originalName, 'public');

            $fullPath = Storage::disk('public')->path($path);
            $entity->FileLocation = $fullPath;
            $entity->appendLog('2-Arquivo salvo em: '.$fullPath);
        } else {
            $entity->appendLog(' | 2-Erro ao salvar arquivo: nenhum arquivo encontrado.');
        }

        // Salva a entidade no banco
        $entity->save();

        return response()->json([
            'success' => true,
            'message' => 'Integração registrada com sucesso',
        ]);
    }

}
