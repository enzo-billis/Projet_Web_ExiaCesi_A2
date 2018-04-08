<?php

use Illuminate\Database\Seeder;

class InscriptionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        DB::table('inscriptions')->insert([
            'date' => $faker->date('Y-m-d'),
            'activity' => $faker->numberBetween(1,50),
            'user' => $faker->numberBetween(1,50),
        ]);
    }
}