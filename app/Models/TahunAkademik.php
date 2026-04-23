<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TahunAkademik extends Model
{
    use HasFactory;
    protected $fillable = ['nama_tahun', 'semester', 'status_aktif'];

    public static function aktif() {
    return self::where('status_aktif', true)->first();
}
}


