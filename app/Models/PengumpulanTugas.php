<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PengumpulanTugas extends Model
{
    use HasFactory;
    protected $fillable = [
        'tugas_id', 'siswa_id', 'file_jawaban', 'catatan_siswa', 'nilai', 'catatan_guru'
    ];

    public function tugas()
    {
        return $this->belongsTo(Tugas::class);
    }

    public function siswa()
    {
        return $this->belongsTo(User::class, 'siswa_id');
    }
}
