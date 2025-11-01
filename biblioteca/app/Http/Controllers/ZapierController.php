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
        $service = new ZapierService();
        $service->processGoogleDriveUpload($request->allFiles(), $request );

        return response()->json([
            'success' => true,
            'message' => 'Integração registrada com sucesso',
        ]);
    }

}
