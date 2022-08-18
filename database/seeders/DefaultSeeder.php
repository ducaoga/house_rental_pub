<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DefaultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //default admin account
        DB::table('users')->insert([
            'name' => 1000,
            'email' => 'gail@rental.com',
            'password' => Hash::make('gail.1234'),
            'is_active' => 1,
            'user_role' => 99,
        ]);

        //default account type
        DB::table('room_templates')->insert([
            ['room_price' => 5000, 'room_description' => 'Small Room', 'is_active' => 1],
            ['room_price' => 8000, 'room_description' => 'Medium Room', 'is_active' => 1],
            ['room_price' => 10300, 'room_description' => 'Deluxe Room', 'is_active' => 1],
        ]);
    }
}
