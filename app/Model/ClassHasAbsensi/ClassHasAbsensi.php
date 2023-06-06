<?php

namespace App\model\ClassHasAbsensi;

use Illuminate\Database\Eloquent\Model;

class ClassHasAbsensi extends Model
{
    protected $table = 'tbl_class_has_absensi';

    protected $fillable = [
        'class_id',
        'date',
        'present',
        'sick',
        'permission',
        'absensi',
        'ket',
        'lokasi',
    ];


}
