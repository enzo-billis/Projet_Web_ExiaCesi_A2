<?php

use Illuminate\Database\Seeder;

class PublishActivitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        DB::table('published_activity')->insert([
            'date_publish' => $faker->date('Y-m-d'),
            'user' => $faker->numberBetween(1,50),
            'activity' => $faker->numberBetween(1,50),
        ]);
    }
}