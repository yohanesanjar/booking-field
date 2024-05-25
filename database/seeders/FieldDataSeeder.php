<?php

namespace Database\Seeders;

use App\Models\FieldData;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FieldDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FieldData::create([
            'name' => 'Lapangan 1',
            'description' => 'Ini Lapangan 1',
            'field_type' => 'Futsal',
            'field_material' => 'Plur',
            'field_location' => 'Indoor',
            'morning_price' => 90000,
            'night_price' => 100000,
            'thumbnail' => 'lapangan-1.jpg',
        ]);
        FieldData::create([
            'name' => 'Lapangan 2',
            'description' => 'Ini Lapangan 2',
            'field_type' => 'Futsal',
            'field_material' => 'Rumput Sintetis',
            'field_location' => 'Indoor',
            'morning_price' => 90000,
            'night_price' => 100000,
            'thumbnail' => 'lapangan-2.jpg',
        ]);
        FieldData::create([
            'name' => 'Lapangan 1',
            'description' => 'Ini Lapangan 1',
            'field_type' => 'Bulu Tangkis',
            'field_material' => 'Plur',
            'field_location' => 'Indoor',
            'morning_price' => 30000,
            'night_price' => 30000,
            'thumbnail' => 'lapangan-3.jpg',
        ]);
        FieldData::create([
            'name' => 'Lapangan 2',
            'description' => 'Ini Lapangan 2',
            'field_type' => 'Bulu Tangkis',
            'field_material' => 'Plur',
            'field_location' => 'Indoor',
            'morning_price' => 30000,
            'night_price' => 30000,
            'thumbnail' => 'lapangan-4.jpg',
        ]);
        FieldData::create([
            'name' => 'Lapangan 3',
            'description' => 'Ini Lapangan 3',
            'field_type' => 'Bulu Tangkis',
            'field_material' => 'Plur',
            'field_location' => 'Indoor',
            'morning_price' => 30000,
            'night_price' => 30000,
            'thumbnail' => 'lapangan-5.jpg',
        ]);
        FieldData::create([
            'name' => 'Lapangan 4',
            'description' => 'Ini Lapangan 4',
            'field_type' => 'Bulu Tangkis',
            'field_material' => 'Plur',
            'field_location' => 'Indoor',
            'morning_price' => 30000,
            'night_price' => 30000,
            'thumbnail' => 'lapangan-6.jpg',
        ]);
        FieldData::create([
            'name' => 'Lapangan 5',
            'description' => 'Ini Lapangan 5',
            'field_type' => 'Bulu Tangkis',
            'field_material' => 'Plur',
            'field_location' => 'Indoor',
            'morning_price' => 30000,
            'night_price' => 30000,
            'thumbnail' => 'lapangan-7.jpg',
        ]);
    }
}
