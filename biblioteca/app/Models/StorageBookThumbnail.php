<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StorageBookThumbnail extends Model
{
    use HasFactory;
    protected $table = 'storage_book_thumbnails';
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
