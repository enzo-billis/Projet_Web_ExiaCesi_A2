<?php

use Illuminate\Database\Seeder;

class LikeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 300; $i++) {
            DB::table('likes')->insert([

                'date_like' => $faker->date('Y-m-d'),
                'id_users' => $faker->numberBetween(1, 50),
                'id_pictures' => $faker->numberBetween(1, 50),
            ]);
        }
    }
}