<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ZapierIntegration', function (Blueprint $table) {
            $table->id('SeqZapierIntegration');
            $table->string('NomeIntegracao', 100);
            $table->string('Evento', 100)->nullable();
            $table->json('Payload')->nullable();
            $table->boolean('Ativo')->default(true);
            $table->timestamp('DataRecebimento')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ZapierIntegration');
    }
};
