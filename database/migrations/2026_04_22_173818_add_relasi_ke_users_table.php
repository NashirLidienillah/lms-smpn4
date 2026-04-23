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
        Schema::table('users', function (Blueprint $table) {
            // Menambahkan kolom untuk menyimpan ID kelas dan ID mapel
            // nullable() artinya kolom ini boleh kosong (karena Admin tidak punya kelas/mapel)
            // onDelete('set null') artinya jika kelas dihapus, data siswa tidak ikut terhapus, hanya status kelasnya jadi kosong
            $table->foreignId('kelas_id')->nullable()->constrained('kelas')->onDelete('set null');
            $table->foreignId('mapel_id')->nullable()->constrained('mapels')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['kelas_id']);
            $table->dropForeign(['mapel_id']);
            $table->dropColumn(['kelas_id', 'mapel_id']);
        });
    }
};
