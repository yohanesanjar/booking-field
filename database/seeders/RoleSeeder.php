<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::create([
            'name' => 'owner'
        ]);
        Role::create([
            'name' => 'advisor'
        ]);
        Role::create([
            'name' => 'user'
        ]);
    }
}