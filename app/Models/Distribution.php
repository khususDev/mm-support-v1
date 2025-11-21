<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distribution extends Model
{
    use HasFactory;
    public $table = "distribution";
    protected $fillable = [
        'nodocument',
        'user_id',
        'created_by',
    ];

    public function document()
    {
        return $this->belongsTo(Documents::class, 'nodocument');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
