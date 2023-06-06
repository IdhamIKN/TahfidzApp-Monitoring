<?php

namespace App\model\Attendance;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $table = 'tb_attendance';
    protected $fillable = ['name', 'label', 'singkatan', 'value', 'created_at', 'updated_at'];
    protected $primaryKey = 'id';
    public $timestamps = true;
}
