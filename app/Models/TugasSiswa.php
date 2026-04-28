<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Testing\Fluent\Concerns\Has;

class TugasSiswa extends Model
{
    use HasFactory;
    protected $table = 'tugas_siswas';
    protected $guarded = ['id'];
    

    public function tugas() {
        return $this->belongsTo(Tugas::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
