<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
           Schema::table('ZapierIntegration', function (Blueprint $table) {
            $table->string('FileLocation', 255)->nullable()->after('DataRecebimento');
            $table->text('Log')->nullable()->after('FileLocation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ZapierIntegration', function (Blueprint $table) {
            $table->dropColumn(['FileLocation', 'Log']);
        });
    }
};
