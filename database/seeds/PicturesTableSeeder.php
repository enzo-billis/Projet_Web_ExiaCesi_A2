<?php

use Illuminate\Database\Seeder;

class PicturesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 20; $i++) {
            DB::table('pictures')->insert([

                'picture' => $faker->imageUrl(640, 480),

                'date_image' => $faker->date('Y-m-d'),
                'id_users' => $faker->numberBetween(1, 50),
                'id_event' => $faker->numberBetween(1, 50),
            ]);
        }
    }
}