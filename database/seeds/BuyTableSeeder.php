<?php

use Illuminate\Database\Seeder;

class BuyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        DB::table('buys')->insert([
            'quantity' => $faker->numberBetween(1,10),
            'status' => $faker->numberBetween(0,2),
            'user' => $faker->numberBetween(1,50),
            'product' => $faker->numberBetween(1,50),
        ]);
    }
}