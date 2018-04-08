<?php

use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $category = array ("Textiles","Pins","Chaussures","Casquettes","Billets","Photos");

        DB::table('category')->insert([
            'name' => $faker->randomElement($category),
            'description' => $faker->text,

        ]);
    }
}