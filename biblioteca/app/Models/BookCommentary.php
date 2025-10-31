<?php

namespace App\Models;

use App\Http\Requests\CreateUserCommentRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

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
    public static function createUserComment(CreateUserCommentRequest $request)    
    {
        $comment = BookCommentary::create([
            'book_id' => $request->book_id,
            'user_id' => $request->user_id,
            'comment' => $request->comment,
        ]);

        Log::info('Novo comentário criado', [
            'book_id' => $comment->book_id,
            'user_id' => $comment->user_id,
        ]);
    }
    
}
