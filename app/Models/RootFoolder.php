<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RootFoolder extends Model
{
    use HasFactory;
    protected $table = 'root_folder';
    protected $fillable = ['name', 'created_by'];
}
