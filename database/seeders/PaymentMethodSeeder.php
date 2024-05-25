<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PaymentMethod::create([
            'name' => 'Cash',
        ]);
        
        PaymentMethod::create([
            'name' => 'BCA',
            'account_number' => '1234567890',
            'account_name' => 'John Doe',
        ]);

        PaymentMethod::create([
            'name' => 'Mandiri',
            'account_number' => '1011121314',
            'account_name' => 'John Doe',
        ]);

        PaymentMethod::create([
            'name' => 'GoPay',
            'account_number' => '087654321012',
            'account_name' => 'John Doe',
        ]);
    }
}
