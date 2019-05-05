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
        $this->call(AuthorsTableSeeder::class);
        //$this->call(OrdersTableSeeder::class);
        $this->call(BooksTableSeeder::class);
        $this->call(ImagesTableSeeder::class);
        //$this->call(OrderlogsTableSeeder::class);

    }
}
