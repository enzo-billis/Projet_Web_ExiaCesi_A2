<?php

use Illuminate\Database\Seeder;

class CatalogTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();


        DB::table('catalog')->insert([
            'name' => $faker->domainWord,
            'description' => $faker->text,
            'image' => $faker->imageUrl(480,640),
            'stock' => $faker->numberBetween(0,200),
            'price' => $faker->numberBetween(1,50),
            'category' => $faker->numberBetween(0,5),
        ]);
    }
}