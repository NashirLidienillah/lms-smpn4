<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rombel extends Model
{
    protected $fillable = ['user_id', 'kelas_id', 'tahun_akademik_id'];

    public function user() { return $this->belongsTo(User::class); }
    public function kelas() { return $this->belongsTo(Kelas::class); }
    public function tahunAkademik() { return $this->belongsTo(TahunAkademik::class); }
}
