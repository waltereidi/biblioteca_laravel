<?php

namespace App\Http\Controllers;

use App\Models\ZapierIntegration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ZapierController extends Controller
{
    /**
     * Recebe uma requisição POST enviada pelo Zapier.
     */
    public function googleDriveFileUpload(Request $request)
    {
        $data = $request->all();

        ZapierIntegration::create([
            'NomeIntegracao' => 'ZapierGoogleDriveAPI',
            'Evento' => $request->input('event', 'unknown'),
            'Payload' => ['teste'],
            'Ativo' => true,
        ]);

        $file = $request->file('file');
        // Armazena em storage/app/uploads (usando o driver configurado)
        $path = $file->store('GoogleDriveBooks');


        return response()->json([
            'success' => true,
            'message' => 'Integração registrada com sucesso',
        ]);

    }
}
