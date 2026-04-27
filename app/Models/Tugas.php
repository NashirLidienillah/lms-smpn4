<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tugas extends Model
{
    use HasFactory;
    protected $fillable = [
        'guru_mapel_id', 'judul', 'deskripsi', 'file_tugas', 'batas_waktu'
    ];
    // Relasi agar tanggal batas waktu otomatis jadi objek Carbon (bisa diotak-atik formatnya)
    protected $casts = [
        'batas_waktu' => 'datetime',
    ];

    public function guruMapel()
    {
        return $this->belongsTo(GuruMapel::class);
    }

    public function pengumpulans()
    {
        return $this->hasMany(PengumpulanTugas::class);
    }
}
