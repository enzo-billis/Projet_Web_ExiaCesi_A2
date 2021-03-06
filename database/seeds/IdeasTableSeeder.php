<?php

use Illuminate\Database\Seeder;

class IdeasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 30; $i++) {
            DB::table('ideas')->insert([
                'name' => $faker->domainWord,
                'description' => $faker->text,
                'image' => $faker->imageUrl(400, 280),
                'user' => $faker->numberBetween(1, 15),

            ]);
        }
    }
}