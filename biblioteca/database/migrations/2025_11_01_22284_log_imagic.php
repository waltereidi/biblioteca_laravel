<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Executa a criação da tabela log_imagick_job.
     */
    public function up(): void
    {
        Schema::create('log_imagick_job', function (Blueprint $table) {
            $table->id(); // equivale a bigIncrements('id')
            $table->string('description', 500)->nullable();
            $table->string('severity', 50)->nullable();
            $table->timestamps(); // cria created_at e updated_at
        });
    }

    /**
     * Reverte a criação da tabela.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_imagick_job');
    }
};
