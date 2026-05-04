<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabanUjian extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ujian_id',
        'soal_id',
        'jawaban_terpilih',
        'is_benar'
    ];

    // Opsional: Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}