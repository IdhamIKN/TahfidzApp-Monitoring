<?php

namespace App\Model\Jurnal;

use Illuminate\Database\Eloquent\Model;
use App\Model\StudentClass\StudentClass;
use App\Model\User\User;

class Jurnal extends Model
{
    protected $table = 'jurnal';
    protected $guard_name = 'web';

    protected $fillable = [
        'id',
        'id_guru',
        'jampel',
        'pertemuan',
        'materi',
        'indikator',
        'pencapaian',
        'kehadiran',
        'class'
    ];


    protected $primaryKey = 'id';

    public $timestamps = false;
    // Definisi relasi Many-to-One dengan model User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_guru', 'id'); // sesuaikan dengan nama relasi dan kunci asing pada tabel
    }

    // Definisi relasi Many-to-One dengan model StudentClass
    public function studentClass()
    {
        return $this->belongsTo(StudentClass::class, 'class', 'id'); // sesuaikan dengan nama relasi dan kunci asing pada tabel
    }

    // Metode accessor untuk mengakses nama lengkap guru
    public function getFullNameAttribute()
    {
        // Akses relasi user dan ambil atribut 'full_name' dari model User
        return $this->user->full_name;
    }

    // Metode accessor untuk mengakses nama kelas
    public function getClassNameAttribute()
    {
        // Akses relasi studentClass dan ambil atribut 'class_name' dari model StudentClass
        return $this->studentClass->class_name;
    }
}
