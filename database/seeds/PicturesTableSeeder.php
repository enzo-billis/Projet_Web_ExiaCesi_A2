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
        for ($i = 0; $i < 50; $i++) {
            DB::table('pictures')->insert([
                'picture' => $faker->imageUrl(640, 480),
                'id_users' => $faker->numberBetween(1, 30),
                'id_event' => $faker->numberBetween(1, 30),
            ]);
        }
    }
}