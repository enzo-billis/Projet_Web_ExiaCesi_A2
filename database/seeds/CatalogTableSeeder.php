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


        DB::table('catalogs')->insert([
            'name' => $faker->domainWord,
            'description' => $faker->text,
            'image' => $faker->imageUrl(480,640),
            'price' => $faker->randomFloat(2,1,100),
            'category' => $faker->numberBetween(0,5),
        ]);
    }
}