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
            'name' => 'Yohanes Anjar',
            'username' => 'yohanesanjar',
            'email' => 'yohanes@gmail.com',
            'password' => bcrypt('123'),
            'role_id' => 1
        ]);

        User::create([
            'name' => 'Maulana',
            'username' => 'maulana',
            'email' => 'maulana@gmail.com',
            'password' => bcrypt('123'),
            'role_id' => 1
        ]);

        User::create([
            'name' => 'Junita Veron',
            'username' => 'junita',
            'email' => 'junita@gmail.com',
            'password' => bcrypt('123'),
            'role_id' => 3
        ]);

        User::create([
            'name' => 'Ali Dongan',
            'username' => 'ali',
            'email' => 'ali@gmail.com',
            'password' => bcrypt('123'),
            'role_id' => 3
        ]);
    }
}