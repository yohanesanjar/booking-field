<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'username' => 'yohanesanjar',
            'email' => 'yohanes@gmail.com',
            'password' => bcrypt('123'),
            'role_id' => 1
        ]);
        User::create([
            'username' => 'junita',
            'email' => 'junita@gmail.com',
            'password' => bcrypt('123'),
            'role_id' => 3
        ]);
    }
}