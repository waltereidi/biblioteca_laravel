<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserCommentRequest;
use App\Models\BookCommentary;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    /**
     * Recebe uma requisição POST enviada pelo Zapier.
     */
    public function CreateUserComment(CreateUserCommentRequest $request)
    {
        try {
            BookCommentary::createUserComment($request);
            
            return response()->json([
                'success' => true,
                'message' => 'Comentário criado com sucesso!',
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao salvar o comentário',
                'error' => $e->getMessage()
            ], 500);
        }

    }
}