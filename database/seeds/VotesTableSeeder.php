<?php

use Illuminate\Database\Seeder;

class VotesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 200; $i++) {
            DB::table('votes')->insert([
                'date_vote' => $faker->date('Y-m-d'),
                'idea' => $faker->numberBetween(1, 50),
                'user' => $faker->numberBetween(1, 50),
                'vote' => $faker->numberBetween(0, 1),
            ]);
        }
    }
}