<?php

use Illuminate\Database\Seeder;

class CommentTableSeeder extends Seeder
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
            DB::table('comment')->insert([
                'id_pictures' => $faker->numberBetween(1, 50),
                'id_users' => $faker->numberBetween(1, 50),
                'comment' => $faker->text,
                'date_comment' => $faker->date('Y-m-d'),
            ]);
        }
    }
}