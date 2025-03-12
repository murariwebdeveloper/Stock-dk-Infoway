<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class StockEntrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        // Get all store IDs from the stores table
        $storeIds = DB::table('stores')->pluck('id')->toArray();
        for ($i = 1; $i <= 100; $i++) {
            $stock_no =  intval(DB::table('stock_entries')->max('id') ?? 0 ) + 1000001;
            DB::table('stock_entries')->insert([
                'stock_no' => $stock_no,
                'item_code' => strtoupper($faker->lexify('?????')),
                'item_name' => $faker->word,
                'quantity' => $faker->numberBetween(1, 100),
                'location' => strtoupper($faker->lexify('??')),
                'store_id' => $faker->randomElement($storeIds),
                'in_stock_date' => $faker->dateTimeBetween('-1 month', '+1 month')->format('Y-m-d'),
                'status' => 'Pending',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

    }
}
