<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogPresensiMateri extends Model
{
    use HasFactory;

    protected $fillable = ['materi_id', 'siswa_id', 'waktu_akses'];

    public function siswa()
    {
        return $this->belongsTo(User::class, 'siswa_id');
    }

    public function materi()
    {
        return $this->belongsTo(Materi::class, 'materi_id');
    }
}