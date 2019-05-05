<?php

use Illuminate\Database\Seeder;

class OrderlogsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $logentry1 = new App\Orderlog();
        $logentry1->comment = "Ihre Bestellung wurde versendet! Sie wird am Dienstag eintreffen.";
        $logentry1->comment_admin = "Status geändert von Bezahlt zu Versendet";
        $logentry1->state = "2";
        $logentry1->username = "Testuser";
        $order1 = App\Order::where('id', 1)->pluck("id");
        //eventuell mal nach Zeitpunkt zusammenmatchen
        $logentry1->order()->associate($order1->first());
        $logentry1->save();

        $logentry2 = new App\Orderlog();
        $logentry2->comment = "Ihre Bestellung wird bearbeitet!";
        $logentry2->comment_admin = "Status geändert zu Offen.";
        $logentry2->state = "0";
        $logentry2->username = "Testuser";
        $order2 = App\Order::where('id', 2)->pluck("id");
        //eventuell mal nach Zeitpunkt zusammenmatchen
        $logentry2->order()->associate($order2->first());
        $logentry2->save();

        $logentry3 = new App\Orderlog();
        $logentry3->comment = "Ihre Bestellung wurde erfolgreich storniert!";
        $logentry3->comment_admin = "Status geändert von Offen zu Storniert.";
        $logentry3->state = "3";
        $logentry3->username = "Testuser";
        $logentry3->order()->associate($order2->first());
        $logentry3->save();
    }
}
