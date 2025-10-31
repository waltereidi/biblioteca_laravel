<?php

namespace App\Models;

use App\Http\Requests\CreateUserCommentRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
class Book extends Model
{
 use HasFactory;

    // Por padrão o Laravel já usará a tabela 'books'.
    // Se quiser forçar um nome diferente (ex.: 'Books' com B maiúsculo), descomente:
    // protected $table = 'Books';

    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'title',
        'author',
        'isbn',
        'pages',
        'published_at',
        'available',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'available'    => 'boolean',
        'pages'        => 'integer',
    ];

}
