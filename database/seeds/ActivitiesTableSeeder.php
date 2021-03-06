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
        for ($i = 0; $i < 30; $i++) {
            DB::table('activities')->insert([
                'name' => $faker->domainWord,
                'image' => $faker->imageUrl(400, 280),
                'description' => $faker->text,
                'recurrence' => $faker->domainWord,
                'date_add' => $faker->date('Y-m-d', '2019-01-01'),
                'price' => $faker->randomFloat(2, 0, 100),
                'month_activity' => $faker->numberBetween(0, 1),
                'status' => $faker->numberBetween(0, 3),
            ]);
        }
    }
}