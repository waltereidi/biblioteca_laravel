<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserCommentRequest extends FormRequest
{
/**
     * Determina se o usuário está autorizado a fazer esta requisição.
     */
    public function authorize(): bool
    {
        // Pode colocar regras de permissão aqui se necessário
        return true;
    }

    /**
     * Define as regras de validação.
     */
    public function rules(): array
    {
        return [
            'book_id' => 'required|integer|exists:books,id',
            'user_id' => 'required|integer|exists:users,id',
            'comment' => 'required|string|max:1000',
        ];
    }

    /**
     * Define mensagens personalizadas para erros.
     */
    public function messages(): array
    {
        return [
            'book_id.required' => 'O ID do livro é obrigatório.',
            'book_id.exists' => 'O livro informado não existe.',
            'user_id.required' => 'O ID do usuário é obrigatório.',
            'user_id.exists' => 'O usuário informado não existe.',
            'comment.required' => 'O comentário não pode estar vazio.',
            'comment.max' => 'O comentário não pode exceder 1000 caracteres.',
        ];
    }
}
