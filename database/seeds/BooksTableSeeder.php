<?php

use Illuminate\Database\Seeder;
use App\Book;


class BooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = App\User::all()->first();

        $book = new Book;
        $book->title = "Herr der Ringe";
        $book->subtitle = "Die Gefährten";
        $book->isbn = "6666666666";
        $book->rating = 10;
        $book->description = "Erster Teil ... ";
        $book->published = new DateTime();
        $book->price = "25.50";
        $book->user()->associate($user);
        $book->save();
        //$authors = App\Author::all()->pluck("id");
        $authors = App\Author::where('firstName', 'Max')->pluck("id");
        $book->authors()->sync($authors);
        $book->save();
        //das save ist hier sehr wichtig, ansonsten würden die authoren nicht in der Datenbank speichern
        //save // update sind Persetierungsmethoden für die Datenbank
        $orders = App\Order::where('id', 1)->pluck("id");
        $book->orders()->sync($orders);
        $book->save();

        $book2 = new Book;
        $book2->title = "Herr der Ringe 2";
        $book2->subtitle = "Die zwei Türme";
        $book2->isbn = "5555555555";
        $book2->rating = 10;
        $book2->description = "Zweiter Teil ... ";
        $book2->published = new DateTime();
        $book2->price = "20.50";
        //map existing user to book
        $book2->user()->associate($user);
        $book2->save();
        $authors2 = App\Author::where('firstName', 'Heinz')->pluck("id");
        $book2->authors()->sync($authors2);
        $orders = App\Order::where('id', 2)->pluck("id");
        $book2->orders()->sync($orders);
        $book2->save();

        $book3 = new Book;
        $book3->title = "Der Ernährungskompass";
        $book3->subtitle = "Das Kochbuch";
        $book3->isbn = "1111111111";
        $book3->rating = 9;
        $book3->description = "Mit seinem »Ernährungskompass« eroberte Bas Kast die Bestsellerlisten. 
        Jetzt hat er zusammen mit der Rezepte-Entwicklerin Michaela Baur ein Kochbuch verfasst, 
        das die wissenschaftlich begründeten Regeln gesunden Essens für den Ernährungsalltag umsetzt.";
        $book3->published = new DateTime();
        $book3->price = "15.00";
        //map existing user to book
        $book3->user()->associate($user);
        $book3->save();
        $authors3 = App\Author::where('firstName', 'Bas')->pluck("id");
        $book3->authors()->sync($authors3);
        $orders = App\Order::where('id', 1)->pluck("id");
        $book3->orders()->sync($orders);
        $book3->save();

        $book4 = new Book;
        $book4->title = "MontanaBlack";
        $book4->subtitle = "Vom Junkie zum YouTuber";
        $book4->isbn = "2222222222";
        $book4->rating = 7;
        $book4->description = "Mit Anfang 20 ist Marcel Eris an seinem absoluten Tiefpunkt. 
        Er ist drogenabhängig, hat keine Arbeit und wird obdachlos. Um an Geld für Gras und Kokain zu kommen, 
        knackt er Autos und steigt in Häuser ein. Nichts deutet darauf hin, 
        dass dieser perspektivlose Drogenabhängige aus Buxtehude es schaffen sollte, 
        noch einmal in ein normales Leben zurückzukehren.";
        $book4->published = new DateTime();
        $book4->price = "10.99";
        //map existing user to book
        $book4->user()->associate($user);
        $book4->save();
        $authors = App\Author::where('firstName', 'B.C.')->pluck("id");
        $book4->authors()->sync($authors);
        $orders = App\Order::where('id', 1)->pluck("id");
        $book4->orders()->sync($orders);
        $book4->save();

        $book5 = new Book;
        $book5->title = "Das kleine Cafe am Meer";
        $book5->subtitle = "Teil 2";
        $book5->isbn = "3333333333";
        $book5->rating = 5;
        $book5->description = "Für die hübsche Hannah Blumberg, 
        Assistentin in der Modebranche mit einer Vorliebe für teure Handtaschen, läuft es gerade gar nicht gut: 
        Erst wird ihr Arbeitsvertrag nicht verlängert, und dann macht auch noch ihr Freund mit ihr Schluss. Per Mail.";
        $book5->published = new DateTime();
        $book5->price = "26.00";
        //map existing user to book
        $book5->user()->associate($user);
        $book5->save();
        $authors5 = App\Author::where('firstName', 'Anja Saskia')->pluck("id");
        $book5->authors()->sync($authors5);
        $orders5 = App\Order::where('id', 3)->pluck("id");
        $book5->orders()->sync($orders5);
        $book5->save();

        $book6 = new Book;
        $book6->title = "Böses Geheimnis";
        $book6->subtitle = "Levi Kant 1";
        $book6->isbn = "4444444444";
        $book6->rating = 6;
        $book6->description = "An diesem Tag vor fünf Jahren verschwanden der Mann und die kleine Tochter der Psychiaterin Olivia Hofmann. 
        Seit fünf Jahren ist auch der Mörder der vierzehnjährigen Lisa Manz auf freiem Fuß. ";
        $book6->published = new DateTime();
        $book6->price = "22.50";
        //map existing user to book
        $book6->user()->associate($user);
        $book6->save();
        $authors6 = App\Author::where('firstName', 'Marcel')->pluck("id");
        $book6->authors()->sync($authors6);
        $orders6 = App\Order::where('id', 3)->pluck("id");
        $book6->orders()->sync($orders6);
        $book6->save();

    }
}
