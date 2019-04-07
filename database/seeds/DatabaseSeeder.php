<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        factory(App\Hotels::class, 10)->create()->each(function ($hotel) {
            factory(App\Rooms::class, 20)->create(['hotels_id' => $hotel->id]);
        });
    }
}
