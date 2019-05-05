<?php

use Illuminate\Database\Seeder;

class ImagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $image1 = new App\Image();
        $image1->title = "Die Gefährten";
        $image1->url = "https://images-na.ssl-images-amazon.com/images/I/51Q832vk98L._SX319_BO1,204,203,200_.jpg";
        $book = App\Book::where('isbn', '6666666666')->pluck("id");
        $image1->book()->associate($book->first());
        $image1->save();

        $image2 = new App\Image();
        $image2->title = "Die zwei Türme";
        $image2->url = "https://images-na.ssl-images-amazon.com/images/I/51smfUvItSL._SX319_BO1,204,203,200_.jpg";
        $book2 = App\Book::where('isbn', '5555555555')->pluck("id");
        $image2->book()->associate($book2->first());
        $image2->save();

        $image3 = new App\Image();
        $image3->title = "Ernährungskompass";
        $image3->url = "https://images-na.ssl-images-amazon.com/images/I/51opitW-6EL._SX404_BO1,204,203,200_.jpg";
        $book3 = App\Book::where('isbn', '1111111111')->pluck("id");
        $image3->book()->associate($book3->first());
        $image3->save();

        $image4 = new App\Image();
        $image4->title = "MontanaBlack";
        $image4->url = "https://images-na.ssl-images-amazon.com/images/I/41n904XB3zL._SX335_BO1,204,203,200_.jpg";
        $book4 = App\Book::where('isbn', '2222222222')->pluck("id");
        $image4->book()->associate($book4->first());
        $image4->save();

        $image5 = new App\Image();
        $image5->title = "Cafe am Meer";
        $image5->url = "https://images-eu.ssl-images-amazon.com/images/I/513QExnspRL.jpg";
        $book5 = App\Book::where('isbn', '3333333333')->pluck("id");
        $image5->book()->associate($book5->first());
        $image5->save();

        $image6 = new App\Image();
        $image6->title = "Böses Geheimnis";
        $image6->url = "https://images-eu.ssl-images-amazon.com/images/I/51CEhy6yBOL.jpg";
        $book6 = App\Book::where('isbn', '4444444444')->pluck("id");
        $image6->book()->associate($book6->first());
        $image6->save();

        $image7 = new App\Image();
        $image7->title = "Rezept zum Ernährungskompass";
        $image7->url = "https://images-na.ssl-images-amazon.com/images/I/716zvfFwAgL.jpg";
        $book7 = App\Book::where('isbn', '1111111111')->pluck("id");
        $image7->book()->associate($book7->first());
        $image7->save();

        $image8 = new App\Image();
        $image8->title = "Rezept 2 zum Ernährungskompass";
        $image8->url = "https://images-na.ssl-images-amazon.com/images/I/71gaoMjtCzL.jpg";
        $book8 = App\Book::where('isbn', '1111111111')->pluck("id");
        $image8->book()->associate($book8->first());
        $image8->save();

        $image9 = new App\Image();
        $image9->title = "Bild 2 zu Montana Black";
        $image9->url = "https://images-na.ssl-images-amazon.com/images/I/81o1ygGPHbL.jpg";
        $book9 = App\Book::where('isbn', '2222222222')->pluck("id");
        $image9->book()->associate($book9->first());
        $image9->save();
    }
}
