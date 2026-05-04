<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ujian extends Model
{
    protected $fillable = ['guru_mapel_id', 'judul', 'durasi', 'mulai', 'selesai', 'is_published'];
    protected $casts = ['mulai' => 'datetime', 'selesai' => 'datetime'];

    public function soals() { 
        return $this->hasMany(Soal::class); 
    }

    public function guruMapel() {
        return $this->belongsTo(GuruMapel::class, 'guru_mapel_id');
    }
}