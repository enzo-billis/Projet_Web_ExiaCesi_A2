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

        DB::table('ideas')->insert([
            'name' => $faker->domainWord,
            'description' => $faker->text,
            'image' => $faker->imageUrl(480,640),
            'user' => $faker->numberBetween(1,50),

        ]);
    }
}