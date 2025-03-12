<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        DB::table('users')->insert([
            'name' => 'Super Admin',
            'email' => 'admin@gmail.com', // Change this to your desired admin email
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'), // Set a secure password
            'remember_token' => $faker->regexify('[A-Za-z0-9]{10}'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

    }
}
