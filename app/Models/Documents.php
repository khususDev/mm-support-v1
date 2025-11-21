<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documents extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_document_id',
        'jenis_document_id',
        'department_id',
        'nodocument',
        'namadocument',
        'deskripsi',
        'tanggal_berlaku',
        'tanggal_review',
        'statusdocument',
        'revisidocument',
        'mark_dokumen',
        'created_by'
    ];

    public function distributions()
    {
        return $this->hasMany(Distribution::class, 'nodocument', 'nodocument');
    }

    public function jenisDocument()
    {
        return $this->belongsTo(MasterDocs::class);
    }

    public function division()
    {
        return $this->belongsTo(Department::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'statusdocument', 'id');
    }

    public function paths()
    {
        return $this->hasMany(PathDocument::class, 'nodocument');
    }
}
