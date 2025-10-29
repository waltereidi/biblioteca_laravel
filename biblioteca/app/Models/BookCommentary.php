<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookCommentary extends Model
{
    use HasFactory;
    protected $table = 'BookCommentary';

    protected $primaryKey = 'SeqBookCommentary';
    public $timestamps = true;

    protected $fillable = [
        'BookId',
        'UserId',
        'Comment',
        'Rating',
    ];

    protected $casts = [
        'Rating' => 'integer',
    ];

    // Relacionamento exemplo
    public function book()
    {
        return $this->belongsTo(Book::class, 'BookId');
    }
    
}
