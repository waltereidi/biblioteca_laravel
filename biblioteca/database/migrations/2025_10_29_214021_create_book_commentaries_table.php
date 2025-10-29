<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('BookCommentary', function (Blueprint $table) {
            $table->id('SeqBookCommentary');
            $table->unsignedBigInteger('BookId')->index();
            $table->unsignedBigInteger('UserId')->nullable();
            $table->text('Comment');
            $table->integer('Rating')->default(0);
            $table->timestamps();

            // Exemplo de chave estrangeira (se existir tabela 'books')
            // $table->foreign('BookId')->references('id')->on('books')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('BookCommentary');
    }
};
