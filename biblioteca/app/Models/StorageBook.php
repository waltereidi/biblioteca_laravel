<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StorageBook extends Model
{
    use HasFactory;
    protected $table = 'storage_book';
    protected $primaryKey = 'id';

    protected $fillable = [
        'book_id',
        'storage_path',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id');
    }
    
}
