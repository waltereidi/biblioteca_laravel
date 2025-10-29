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
        // Captura todos os dados da requisição
        $data = $request->except('file'); // remove o campo File

        $entity = new ZapierIntegration();
        $entity->NomeIntegracao = 'ZapierGoogleDriveAPI';
        $entity->Evento = $request->input('event', 'unknown');
        $entity->Payload = $data;
        $entity->Ativo = true;
        $entity->DataRecebimento = now();
        $entity->FileLocation = $filePath ?? null;
        $entity->appendLog('1-Recebido requisição de : '.$request->ip());

        // // Registra a integração com o payload completo (sem o arquivo)
        // Armazena o arquivo no diretório GoogleDriveBooks
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            // Salva dentro de /var/www/html/storage/livros/
            $path = $file->storeAs('livros', $file->getClientOriginalName(), 'public');
            $file = Storage::disk('public')->path($path);
            $entity->FileLocation = $file;    
            $entity->appendLog('2-Arquivo salvo em: '.$file);

        } else {
            $entity->appendLog(' | 2-Erro ao salvar arquivo. ');
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Integração registrada com sucesso',
        ]);
    }

}
