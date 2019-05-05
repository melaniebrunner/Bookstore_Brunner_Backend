<?php

use Illuminate\Database\Seeder;

class AuthorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $a1 = new \App\Author();
        $a1->firstName = "Max";
        $a1->lastName = "Maier";
        $a1->save();

        $a2 = new \App\Author();
        $a2->firstName = "Fritz";
        $a2->lastName = "Huber";
        $a2->save();

        $a3 = new \App\Author();
        $a3->firstName = "Heinz";
        $a3->lastName = "Gruber";
        $a3->save();

        $a4 = new \App\Author();
        $a4->firstName = "Bas";
        $a4->lastName = "Kast";
        $a4->save();

        $a5 = new \App\Author();
        $a5->firstName = "B.C.";
        $a5->lastName = "Schiller";
        $a5->save();

        $a6 = new \App\Author();
        $a6->firstName = "Anja Saskia";
        $a6->lastName = "Beyer";
        $a6->save();

        $a7 = new \App\Author();
        $a7->firstName = "Marcel";
        $a7->lastName = "Eris";
        $a7->save();
    }
}
