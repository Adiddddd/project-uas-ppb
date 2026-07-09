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
        Schema::create('gudangs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_gudang');

            $table->foreignId('id_jenis_gudang')
                  ->constrained('jenis_gudangs')
                  ->cascadeOnDelete();

            $table->decimal('luas_gudang',10,2);
            $table->decimal('volume_gudang',10,2);
            $table->text('keterangan')->nullable();

            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gudangs');
    }
};
