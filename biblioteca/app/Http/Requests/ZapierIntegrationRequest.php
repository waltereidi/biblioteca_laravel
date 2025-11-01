<?php

namespace App\Http\Requests;

use App\Models\Book;
use App\Models\ZapierIntegration;
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
    
    public function createBookFromRequest(): Book
    {
        $book = new Book();
        $book->title = $this->input('title', );
        $book->author = $this->input('author', 'Unknown');
        $book->isbn = $this->input('isbn', '0000000000');
        $book->pages = $this->input('pages', 0);
        $book->published_at = $this->input('published_at', now());
        $book->available = $this->input('available', true);
        $book->save();

        return $book;
    }
    public function createFromRequest(): ZapierIntegration  
    {
        $e = new ZapierIntegration();
        $e->NomeIntegracao = 'ZapierGoogleDriveAPI';
        $e->Evento = $this->input('event', 'unknown');
        $e->Payload = $this->__tostring();
        $e->Ativo = true;
        $e->DataRecebimento =$this->createdDate ?? now();
        $e->appendLog('1-Recebido requisição de : '.$this->ip());
        $e->save();
        return $e;
    }
}
