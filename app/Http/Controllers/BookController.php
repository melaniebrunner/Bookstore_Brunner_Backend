<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

use App\Book;
use App\Author;
use App\User;
use App\Image;

class BookController extends Controller
{
    //
    public function index() {
        $books = Book::with(['authors', 'images','user'])->get();
        return $books;
    }

    public function findByISBN (string $isbn) {
        $book = Book::where('isbn', $isbn)
            ->with(['authors', 'images','user'])
            ->first();
        return $book;
    }

    public function findBySearchTerm(string $searchTerm) {
        $books = Book::with(['authors', 'images', 'user'])
            ->where('title', 'LIKE', '%'. $searchTerm . '%')
            ->orWhere('subtitle', 'LIKE', '%'. $searchTerm . '%')
            ->orWhere('description', 'LIKE', '%'. $searchTerm . '%')

            /* search term in authors relation */
            ->orWhereHas('authors', function ($query) use ($searchTerm){
                $query->where('firstName', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('lastName', 'LIKE', '%' . $searchTerm . '%');
            })

            ->get();
        return $books;
    }

    public function checkISBN (string $isbn){
        $book = Book::where('isbn', $isbn)->first();
        return $book != null ? response()->json('book with ' . $isbn . ' exists', 200)
            : response()->json('book with ' . $isbn . ' does NOT exist', 404);
    }

    public function show($book){
        //normalerweise würde es nicht automatisch die Relationen mitladen, deswegen gebe ich mit with mit an welche Relationen ich mtiladen möchte
        $book = Book::with('authors', 'images', 'orders')->find($book);
        dd($book);
        return view('books.show', compact('book'));

    }



    public function getAddressFromUser(string $userid){
        $user = User::select('address')
            ->where('id', $userid)->get();
        return $user;
    }

    /**
     * create new book
     */

    public function save(Request $request) : JsonResponse{
        $request = $this->parseRequest($request);
        DB::beginTransaction();
        try {
            $book = Book::create($request->all());

            //save image
            if($request['images'] && is_array($request['images'])){
                foreach ($request['images'] as $img){
                    $image = Image::firstOrNew([
                        'url' => $img['url'],
                        'title' => $img['title']
                   ]);
                    //assign image to book
                    $book->images()->save($image);
                }
            }

            //save author
            if($request['authors'] && is_array($request['authors'])){
                foreach ($request['authors'] as $auth){
                    $author = Author::firstOrNew([
                        'firstName' => $auth['firstName'],
                        'lastName' => $auth['lastName']

                    ]);
                    //assign image to book
                    $book->authors()->save($author);
                }
            }

            DB::commit();
            return response()->json($book,201);


        }catch (\Exception $e) {
            DB::rollBack();
            return response()->json('saving book fails' . $e->getMessage(), 420);
        }


    }


    /**
     * Update new Book - von GIST kopiert
     */


    public function update(Request $request, string $isbn) : JsonResponse
    {

        DB::beginTransaction();
        try {
            $book = Book::with(['authors', 'images', 'user'])
                ->where('isbn', $isbn)->first();
            if ($book != null) {
                $request = $this->parseRequest($request);
                $book->update($request->all());

                //delete all old images
                $book->images()->delete();
                // save images
                if (isset($request['images']) && is_array($request['images'])) {
                    foreach ($request['images'] as $img) {
                        $image = Image::firstOrNew(['url' => $img['url'], 'title' => $img['title']]);
                        $book->images()->save($image);
                    }
                }
                //update authors

                $ids = [];
                if (isset($request['authors']) && is_array($request['authors'])) {
                    foreach ($request['authors'] as $auth) {
                        array_push($ids, $auth['id']);
                    }
                }
                //updaten einer m zu n Relation
                $book->authors()->sync($ids);
                $book->save();

            }
            DB::commit();
            $book1 = Book::with(['authors', 'images', 'user'])
                ->where('isbn', $isbn)->first();
            // return a vaild http response
            return response()->json($book1, 201);
        } catch (\Exception $e) {
            // rollback all queries
            DB::rollBack();
            return response()->json("updating book failed: " . $e->getMessage(), 420);

        }
    }

    /**
     * Delete Bookd
     */

    public function delete(string $isbn) : JsonResponse
    {
        $book = Book::where('isbn', $isbn)->first();
        if($book != null){
            $book->delete();
        }
        else{
            throw new \Exception("Book couldn't be deleted -does not exist");
        }

        return response()->json('book' . $isbn . ' deleted', 200);
    }

    private function parseRequest (Request $request) : Request {
        $date = new \DateTime($request->published);
        $request['published'] = $date;
        return $request;
    }


}
