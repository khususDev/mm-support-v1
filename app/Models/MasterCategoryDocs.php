<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterCategoryDocs extends Model
{
    protected $table = 'master_category';
    protected $fillable = ['name', 'code', 'created_id'];

    public function types()
    {
        return $this->hasMany(MasterDocs::class, 'category_id');
    }
}
