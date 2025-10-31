<?php

namespace App\Http\Controllers;

use App\Http\Requests\ZapierIntegrationRequest;
use App\Models\ZapierIntegration;
use App\Service\ZapierService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ZapierController extends Controller
{
    /**
     * Recebe uma requisição POST enviada pelo Zapier.
     */
    public function googleDriveFileUpload(ZapierIntegrationRequest $request)
    {
        // Remove o campo 'file' do payload
        $entity = ZapierIntegration::createFromRequest($request); 
        $entity->appendLog('1-Recebido requisição de : '.$request->ip());

        // Captura o primeiro arquivo enviado (independente do nome do campo)

        $service = new ZapierService();
        $service->processGoogleDriveUpload($request->allFiles(), $entity);

        // Salva a entidade no banco
        $entity->save();

        return response()->json([
            'success' => true,
            'message' => 'Integração registrada com sucesso',
        ]);
    }

}
