<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $password = Hash::make('root');
        for ($i = 0; $i < 30; $i++) {
            DB::table('users')->insert([
                'rang' => $faker->numberBetween(0, 2),
                'image' => $faker->imageUrl(200, 200),
                'firstname' => $faker->firstName,
                'lastname' => $faker->lastName,
                'email' => $faker->email,
                'password' => $password,
            ]);
        }
    }
}
