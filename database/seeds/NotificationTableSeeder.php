<?php

use Illuminate\Database\Seeder;

class NotificationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 300; $i++) {
            DB::table('notifications')->insert([

                'user_source' => $faker->numberBetween(1, 50),
                'user_cible' => $faker->numberBetween(1, 50),
                'content' => $faker->text,
                'date_notif' => $faker->date('Y-m-d'),
                'status' => $faker->numberBetween(1, 2),
            ]);
        }
    }
}