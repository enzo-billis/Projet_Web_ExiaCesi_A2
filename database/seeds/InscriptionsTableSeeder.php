<?php

use App\activitie;
use App\User;
use Illuminate\Database\Seeder;

class InscriptionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 200; $i++) {
           $user = User::findOrFail($faker->numberBetween(1,30));
           $activity = activitie::findOrFail($faker->numberBetween(1,30));

           $user->inscription()->attach($activity , ['date' => $faker->date('Y-m-d')]);
        }
    }
}