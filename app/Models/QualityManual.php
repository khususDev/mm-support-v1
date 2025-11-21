<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QualityManual extends Model
{
    use HasFactory;
    public $table = "quality_manuals";

    protected $fillable = [
        'no_document',
        'revisi',
        'tanggal',
        'nama_document',
        'perusahaan',
        'alamat',
        'created_by',
        'checker',
    ];
}
