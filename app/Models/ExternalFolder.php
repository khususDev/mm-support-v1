<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExternalFolder extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'created_by'
    ];

    public function documents()
    {
        return $this->hasMany(ExternalDocument::class, 'folder_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
