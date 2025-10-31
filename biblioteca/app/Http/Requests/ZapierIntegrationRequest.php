<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ZapierIntegrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'nullable|string|max:255',
            'originalFilename' => 'nullable|string|max:255',
            'file' => 'file|max:10240', // até 10 MB
            'createdDate' => 'nullable|date',
            'mimeType' => 'nullable|string|max:100',
            'thumbnailLink' => 'nullable|url',
        ];
    }
}
