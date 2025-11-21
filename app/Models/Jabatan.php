<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    use HasFactory;
    public $table = "position";
    protected $fillable = [
        'name',
        'code',
        'department_id',
        'created_id',
    ];
}
