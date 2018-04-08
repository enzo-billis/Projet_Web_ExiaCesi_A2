<?php

use Illuminate\Database\Seeder;

class CensorshipTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        DB::table('censorship')->insert([
            'type_object' => $faker->numberBetween(1,2),
            'date_censor' => $faker->date('Y-m-d'),
            'id_object' => $faker->numberBetween(1,50),
            'id_user' => $faker->numberBetween(1,50),
            'reason' => $faker->text,
        ]);
    }
}
