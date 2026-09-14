<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('maintenances', function (Blueprint $table) {
            $table->enum('priority', ['rendah', 'sedang', 'tinggi'])->after('status');
            $table->enum('recurrence', ['tidak', 'mingguan', 'bulanan', 'tahunan'])->default('tidak')->after('priority');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('maintenances', function (Blueprint $table) {
            $table->dropColumn(['priority', 'recurrence']);
        });
    }
};
