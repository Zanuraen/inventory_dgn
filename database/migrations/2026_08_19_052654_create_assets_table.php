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
        Schema::create('assets', function (Blueprint $table) {
        $table->id();
        $table->foreignId('category_id')->constrained('categories')->cascadeOnUpdate();
        $table->string('name');
        $table->string('code_asset')->unique();
        $table->string('serial_number')->nullable();
        $table->string('spesifikasi')->nullable();
        $table->enum('condition_status', ['Baik', 'Rusak Ringan', 'Rusak Berat']);
        $table->integer('qty');
        $table->string('pengguna')->nullable();
        $table->string('location')->nullable();
        $table->date('tanggal_beli');
        $table->decimal('harga_beli', 10, 0);
        $table->string('image')->nullable();
        $table->text('description')->nullable();
        $table->timestamps();
        $table->softDeletes();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
