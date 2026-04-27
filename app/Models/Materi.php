<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Materi extends Model
{
    use HasFactory;
    protected $fillable = [
        'guru_mapel_id',
        'judul',
        'deskripsi',
        'tipe',
        'file_path',
        'url_youtube'
    ];

    public function guruMapel() {
        return $this->belongsTo(GuruMapel::class);
    }
}
