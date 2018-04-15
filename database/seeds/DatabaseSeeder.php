<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

            $this->call(UsersTableSeeder::class);
            $this->call(ActivitiesTableSeeder::class);
            $this->call(BuyTableSeeder::class);
            $this->call(CatalogTableSeeder::class);
            $this->call(CategoryTableSeeder::class);
            $this->call(CensorshipTableSeeder::class);
            $this->call(CommentTableSeeder::class);
            $this->call(IdeasTableSeeder::class);
            $this->call(InscriptionsTableSeeder::class);
            $this->call(LikeTableSeeder::class);
//            $this->call(NotificationTableSeeder::class);
            $this->call(PicturesTableSeeder::class);
            $this->call(PublishActivitiesTableSeeder::class);
            $this->call(VotesTableSeeder::class);
        }


}
