<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PathQualityManual extends Model
{
    use HasFactory;
    protected $table = 'path_qualitymanual';

    protected $fillable = ['no_document', 'jenis', 'title', 'url', 'created_by', 'checker'];

    // Relasi ke Document
    public function document()
    {
        return $this->belongsTo(QualityManual::class, 'no_document');
    }
}
