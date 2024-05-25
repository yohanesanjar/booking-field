<?php

namespace Database\Seeders;

use App\Models\IndexData;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IndexDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        IndexData::create([
            'phone' => '082116862200',
            'email' => 'jayaabadisports@gmail.com',
            'address' => 'Gg. Rambutan No.37, Sumberjaya, Kec. Tambun Sel., Kabupaten Bekasi, Jawa Barat 17510',
        ]);
    }
}
