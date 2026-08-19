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
        Schema::create('maintenances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')->constrained('assets')->cascadeOnDelete()->cascadeOnUpdate();
            $table->date('maintenance_date');
            $table->text('description')->nullable();
            $table->string('jenis_pemeliharaan');
            $table->date('jatuh_tempo');
            $table->decimal('cost', 10, 0)->nullable();
            $table->string('vendor');
            $table->string('kontak_vendor');
            $table->enum('status', ['terjadwal', 'terlambat', 'selesai']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenances');
    }
};
