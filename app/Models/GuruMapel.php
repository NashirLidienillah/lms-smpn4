<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GuruMapel extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'mapel_id', 'kelas_id', 'tahun_akademik_id', 'hari', 'jam_mulai', 'jam_selesai'];

    public function user() { return $this->belongsTo(User::class); }
    public function mapel() { return $this->belongsTo(Mapel::class); }
    public function kelas() { return $this->belongsTo(Kelas::class); }
    public function tahunAkademik() { return $this->belongsTo(TahunAkademik::class); }
}
