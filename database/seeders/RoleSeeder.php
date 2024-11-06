<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        Role::create(['name' => 'Guest']);
        Role::create(['name' => 'User']);
        Role::create(['name' => 'Administrador']);
    }
}

