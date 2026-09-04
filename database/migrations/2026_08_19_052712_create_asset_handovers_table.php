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
        Schema::create('asset_handovers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')->constrained('assets')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('user_id')->constrained('users')->cascadeOnUpdate();

            // Poin 2: membedakan jenis surat — fisik (upload scan) atau digital (isi form)
            $table->enum('jenis_surat', ['fisik', 'digital'])->default('digital');

            // Nama peminjam disimpan sebagai teks bebas, BUKAN foreign key ke users,
            // karena user sistem cuma 1 (admin) — peminjam adalah orang lain (karyawan/divisi)
            $table->string('peminjam_nama');

            $table->string('tujuan_penggunaan')->nullable();
            $table->string('lokasi_penggunaan')->nullable();

            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembalian')->nullable();

            // Poin 4: status siklus peminjaman — dipinjam (baru dibuat) -> dikembalikan (setelah foto_sesudah diisi)
            $table->enum('status', ['dipinjam', 'dikembalikan'])->default('dipinjam');

            $table->text('notes')->nullable();

            // Poin 3: path file scan surat fisik (jika jenis_surat = fisik)
            $table->string('file_path')->nullable();

            // Poin 3 & 4: foto kondisi barang, disimpan sebagai JSON array path
            // karena user boleh upload LEBIH DARI 1 foto.
            // foto_sebelum diisi bersamaan saat surat dibuat (store),
            // foto_sesudah diisi BELAKANGAN saat barang dikembalikan (update terpisah) — poin 4
            $table->json('foto_sebelum')->nullable();
            $table->json('foto_sesudah')->nullable();

            // Checkbox persetujuan tanggung jawab peminjam di form
            $table->boolean('persetujuan')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_handovers');
    }
};