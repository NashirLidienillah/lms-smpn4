<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    use HasFactory;
    protected $table = 'pengumuman';
    protected $fillable = ['kelas_id', 'guru_id', 'judul', 'isi_pengumuman'];
    public function kelas() {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }
    
    public function guru() {
        return $this->belongsTo(User::class, 'guru_id');
    }
}
