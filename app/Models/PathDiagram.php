<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PathDiagram extends Model
{
    use HasFactory;

    protected $table = 'path_diagram';

    protected $fillable = ['nodocument', 'file_code', 'name', 'path'];

    // Relasi ke Document
    public function document()
    {
        return $this->belongsTo(Documents::class, 'nodocument');
    }
}
