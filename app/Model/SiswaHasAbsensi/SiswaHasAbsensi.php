<?php

namespace App\model\SiswaHasAbsensi;

use Illuminate\Database\Eloquent\Model;

class SiswaHasAbsensi extends Model
{
    protected $table = 'tbl_siswa_has_absensi';

    protected $fillable = [
        'class_id',
        'siswa_id',
        'date',
        'attendance',
        'start_date',
        'end_date',
        'ket',
        'lokasi',
    ];

    public function siswa()
    {
        return $this->belongsTo('App\Model\Siswa\Siswa');
    }
}
