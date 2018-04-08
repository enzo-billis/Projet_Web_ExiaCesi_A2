<?php

use Illuminate\Database\Seeder;

class ActivitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        DB::table('activities')->insert([
            'name' => $faker->domainWord,
            'image' => $faker->imageUrl(640,480),
            'description' => $faker->text,
            'date_add' => $faker->date('Y-m-d'),
            'price' => $faker->randomFloat(0,100),
            'month_activity' => $faker->numberBetween(0,1),
        ]);
    }
}
