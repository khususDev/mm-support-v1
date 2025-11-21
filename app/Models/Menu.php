<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    protected $fillable = ['category_id', 'no_urut', 'name', 'url', 'icon', 'parent_id', 'created'];

    // Relasi many-to-many antara Menu dan User
    // Model Menu
    public function category()
    {
        return $this->belongsTo(MenuCategory::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'role_menu', 'menu_id', 'user_id');
    }

    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id'); // Relasi anak dengan parent_id
    }


    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }
}
