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
            'email' => 'yohanesanjar@gmail.com',
            'password' => bcrypt('123'),
            'role_id' => 1,
            'phone' => '081234567890',
        ]);

        User::create([
            'name' => 'Maulana',
            'username' => 'maulana',
            'email' => 'anjardewa01@gmail.com',
            'password' => bcrypt('123'),
            'role_id' => 1,
            'phone' => '081234567891',
        ]);

        User::create([
            'name' => 'Alif Silalahi',
            'username' => 'alif',
            'email' => 'yohanesanjar000@gmail.com',
            'password' => bcrypt('123'),
            'role_id' => 2,
            'phone' => '081234567892',
        ]);

        User::create([
            'name' => 'Ali Dongan',
            'username' => 'ali',
            'email' => '2010631170134@gmail.com',
            'password' => bcrypt('123'),
            'role_id' => 2,
            'phone' => '081234567893',
        ]);
    }
}