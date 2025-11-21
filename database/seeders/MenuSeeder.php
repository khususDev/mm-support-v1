<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('menus')->insert([
            ['name' => 'Dashboard', 'url' => '/dashboard', 'icon' => 'fas fa-home', 'parent_id' => null],
            ['name' => 'Profile', 'url' => '/profile', 'icon' => 'fas fa-user', 'parent_id' => null],
            ['name' => 'General Master', 'url' => '#', 'icon' => 'fas fa-file', 'parent_id' => null],
            ['name' => 'User Management', 'url' => '/users', 'icon' => 'fas fa-users', 'parent_id' => 3],
        ]);
    }
}
