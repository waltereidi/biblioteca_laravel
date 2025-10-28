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

        // Registra a integração com o payload completo (sem o arquivo)
        ZapierIntegration::create([
            'NomeIntegracao' => 'ZapierGoogleDriveAPI',
            'Evento' => $request->input('event', 'unknown'),
            'Payload' => $data,
            'Ativo' => true,
            'DataRecebimento' => now(),
        ]);

        // Armazena o arquivo no diretório GoogleDriveBooks
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('GoogleDriveBooks');
        }else{
             Storage::disk('public')->put('teste.txt', 'Arquivo salvo com sucesso!');
        }

        return response()->json([
            'success' => true,
            'message' => 'Integração registrada com sucesso',
        ]);
    }

}
