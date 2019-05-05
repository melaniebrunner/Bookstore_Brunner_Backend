<?php

use Illuminate\Database\Seeder;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $order1 = new \App\Order();
        $order1->net_amount = "45.50";
        $order1->gross_amount = "54.60";
        $order1->state = "1";
        $order1->delivery_address = "Softwarepark 10, 4232 Hagenberg, A";
        $user = App\User::where('name', 'MelanieBrunner')->pluck("id");
        $order1->user()->associate($user->first());
        $order1->save();

        $order2 = new \App\Order();
        $order2->net_amount = "20";
        $order2->gross_amount = "24";
        $order2->state = "1";
        $order2->delivery_address = "Softwarepark 10, 4232 Hagenberg, A";
        $user2 = App\User::where('name', 'MelanieBrunner')->pluck("id");
        $order2->user()->associate($user2->first());
        $order2->save();

        $order3 = new \App\Order();
        $order3->net_amount = "25";
        $order3->gross_amount = "30";
        $order3->state = "2";
        $order3->delivery_address = "Softwarepark 10, 4232 Hagenberg, A";
        $user3 = App\User::where('name', 'MelanieBrunner')->pluck("id");
        $order3->user()->associate($user3->first());
        $order3->save();
    }
}
