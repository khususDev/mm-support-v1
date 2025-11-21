<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterDocs extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'kode', 'created_id'];
}
