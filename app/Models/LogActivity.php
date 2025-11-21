<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogActivity extends Model
{
    use HasFactory;

    public $table = "log_activities";
    protected $primaryKey = 'log_id';
    public $incrementing = false;

    protected $fillable = [
        'log_id',
        'user_id',
        'modul',
        'action',
        'resource_id',
        'description',
    ];
}
