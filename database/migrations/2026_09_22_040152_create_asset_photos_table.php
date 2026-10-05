<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asset_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')->constrained('assets')->cascadeOnDelete();
            $table->string('path');

            // Penanda foto mana yang sedang jadi "cover" (ditampilkan di tabel index & banner)
            // Hanya 1 baris per asset_id yang boleh bernilai true — logikanya diatur di Model, bukan di DB
            $table->boolean('is_cover')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asset_photos');
    }
};