<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\PaymentOptions;
use App\Models\User;
use App\Models\Settings;
use App\Models\UniformPrice;
use Illuminate\Database\Seeder;
use App\Models\UniformPriceItem;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::factory()->create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'middle_name' => 'Superadmin',
            'email' => 'superadmin@gmail.com',
            'role' => 'superadmin',
        ]);

        User::factory()->create([
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'middle_name' => 'User',
            'email' => 'user@gmail.com',
            'role' => 'user',
        ]);
        
        Settings::insert([
            [
                'module' => 'appointment_max_limit',
                'limit' => 5,
            ],
            [
                'module' => 'appointment_time_limit',
                'limit' => 30,
            ],
            [
                'module' => 'downpayment_percentage',
                'limit' => 50,
            ]
        ]);

        $uniform = UniformPrice::factory()->create([
            'name' => 'Female Uniform Prices',
        ]);

        UniformPriceItem::insert([
            [
                'uniform_price_id' => $uniform->id,
                'name' => 'Blouse',
                'value' => 'blouse',
                'price' => 500,
            ],
            [
                'uniform_price_id' => $uniform->id,
                'name' => 'Pants',
                'value' => 'pants',
                'price' => 500,
            ],
            [
                'uniform_price_id' => $uniform->id,
                'name' => 'Vest',
                'value' => 'vest',
                'price' => 400,
            ],
            [
                'uniform_price_id' => $uniform->id,
                'name' => 'Short',
                'value' => 'short',
                'price' => 400,
            ],
            [
                'uniform_price_id' => $uniform->id,
                'name' => 'Skirt',
                'value' => 'skirt',
                'price' => 400,
            ],
            [
                'uniform_price_id' => $uniform->id,
                'name' => 'Uniform Set with Vest',
                'value' => 'set-2',
                'price' => 1400,
            ],
            [
                'uniform_price_id' => $uniform->id,
                'name' => 'Blazer',
                'value' => 'blazer',
                'price' => 500,
            ],
            [
                'uniform_price_id' => $uniform->id,
                'name' => 'Uniform Set with Blazer',
                'value' => 'set-3',
                'price' => 1500,
            ],
           
        ]);

        $uniform = UniformPrice::factory()->create([
            'name' => 'Male Uniform Prices',
        ]);

        UniformPriceItem::insert([
            [
                'uniform_price_id' => $uniform->id,
                'name' => 'Polo',
                'value' => 'polo',
                'price' => 500,
            ],
            [
                'uniform_price_id' => $uniform->id,
                'name' => 'Pants',
                'value' => 'pants',
                'price' => 500,
            ],
            [
                'uniform_price_id' => $uniform->id,
                'name' => 'Short',
                'value' => 'short',
                'price' => 400,
            ],
            [
                'uniform_price_id' => $uniform->id,
                'name' => 'Set (Pants and Polo)',
                'value' => 'set-1',
                'price' => 1000,
            ],
            [
                'uniform_price_id' => $uniform->id,
                'name' => 'Vest',
                'value' => 'vest',
                'price' => 400,
            ],
            [
                'uniform_price_id' => $uniform->id,
                'name' => 'Uniform Set with Vest',
                'value' => 'set-2',
                'price' => 1400,
            ],
        ]);


        $uniform = UniformPrice::factory()->create([
            'name' => 'Additional Items Prices',
        ]);

        UniformPriceItem::insert([
            [
                'uniform_price_id' => $uniform->id,
                'name' => 'Threads',
                'value' => 'threads',
                'price' => 40,
            ],
            [
                'uniform_price_id' => $uniform->id,
                'name' => 'Zipper',
                'value' => 'zipper',
                'price' => 8,
            ],
            [
                'uniform_price_id' => $uniform->id,
                'name' => 'School Seal',
                'value' => 'school-seal',
                'price' => 50,
            ],
            [
                'uniform_price_id' => $uniform->id,
                'name' => 'Buttons',
                'value' => 'buttons',
                'price' => 8,
            ],
            [
                'uniform_price_id' => $uniform->id,
                'name' => 'Hook and Eye',
                'value' => 'hook and eye',
                'price' => 25,
            ],
            [
                'uniform_price_id' => $uniform->id,
                'name' => 'Tela',
                'value' => 'tela',
                'price' => 79,
            ],
           
        ]);

        PaymentOptions::insert([
            [
                'name' => 'GCash',
                'account_number' => 123123123123,
                'account_name' => 'John Doe',
            ],
            [
                'name' => 'Paypal',
                'account_number' => 123123123123,
                'account_name' => 'Jane Doe',
            ],
        ]);
    }
}
