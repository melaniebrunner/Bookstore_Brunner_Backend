<?php

namespace App\Http\Controllers;

use App\Order;
use App\Orderlog;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

use App\Book;
use App\Image;
use App\Author;
use Psy\Util\Json;
use App\User;

class OrderController extends Controller
{
    public function index() {
        $orders = Order::with(['books', 'user', 'books.images'])->get();
        return $orders;
    }

    public function getSalesTax(){
        return env('SALES_TAX_AT');
    }

    public function getOrderById(int $id){
        $order = Order::where('id', '=', $id)
            ->get();
        return $order;
    }

    public function getPrice(int $orderid, int $bookid){
        $book = Order::select('book_order.price')
            ->join('book_order', 'orders.id', '=', 'book_order.order_id')
            ->where('orders.id', '=', $orderid)
            ->where('book_order.book_id', '=', $bookid)
            ->get();

        return $book;
    }

    public function getOrderlog (){
        $orderlogs = Orderlog::All();
        return $orderlogs;
    }

    public function getState (int $orderid) {
        $state = Order::where('id', $orderid)
           ->select('state')
            ->get();
        return $state;
    }

    public function orderByDatetimeDesc () {
        $orders = Order::with(['books', 'user', 'books.images'])
            ->orderBy('created_at', 'desc')
            ->get();
        return $orders;
    }

    public function orderByDatetimeAsc () {
        $orders = Order::with(['books', 'user', 'books.images'])
            ->orderBy('created_at', 'asc')
            ->get();
        return $orders;
    }

    public function orderFromUserByDatetimeAsc (string $user_id) {
        $orders = Order::where('user_id', '=', $user_id)
            ->with(['books', 'user', 'books.images'])
            ->orderBy('created_at', 'asc')
            ->get();
        return $orders;
    }

    public function orderFromUserByDatetimeDesc (string $user_id) {
        $orders = Order::where('user_id', '=', $user_id)
            ->with(['books', 'user', 'books.images'])
            ->orderBy('created_at', 'desc')
            ->get();
        return $orders;
    }

    public function findByState (int $state) {
        $order = Order::where('state', $state)
            ->with(['books', 'user', 'books.images'])
            ->get();
        return $order;
    }

    public function findFromUserByState (string $user_id, int $state) {
        $orders = Order::where(function($q)use($state,$user_id){
            $q->where('state', '=', $state);
            $q->where('user_id', '=', $user_id);
        })
            ->with(['books', 'user', 'books.images'])
            ->get();
        return $orders;
    }

    public function findByUsername (string $username) {

        $order = Order::select('orders.*', 'users.name')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->where('users.name', '=', $username)
            ->with(['books', 'books.images'])
            ->get();

        return $order;
    }

    public function findByUserId (string $userid) {
        $order = Order::where('orders.user_id', '=', $userid)
            ->with(['books', 'books.images'])
            ->get();

        return $order;
    }

    public function findOrderlogsByUserId (string $userid){
        $orderlogs = Orderlog::join('orders', 'orderlogs.order_id', '=', 'orders.id')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->where('users.id', '=', $userid)
            ->get();

        return $orderlogs;
    }

    public function findBooksByOrderid (int $orderid){
        $books = Book::join('book_order', 'books.id', '=', 'book_order.book_id')
            ->join('orders', 'book_order.order_id', '=', 'orders.id')
            ->with(['images', 'authors', 'user'])
            ->where('book_order.order_id', '=', $orderid)
            ->get();

        return $books;
    }

    public function addOrder (Request $request) : JsonResponse{

        $request = $this->parseRequest($request);
        DB::beginTransaction();

        try {

            $order = Order::create(
                [   'net_amount' => 1,
                    'gross_amount' => 1,
                    'state' => $request['state'],
                    'delivery_address' => $request['delivery_address'],
                    'user_id' => $request['user_id']
                ]
            );

            $net_amount = 0;

            if ($request['books'] && is_array($request['books'])){
                foreach ($request['books'] as $b){
                    $order->books()->attach($b['id'], ['price' => $b['price'], 'count' => $b['count'],
                        'title' => $b['title']]);
                    $net_amount += $b['price'] * $b['count'];
                }
            }

            $order['net_amount'] = $net_amount;

            $tax = env('SALES_TAX_AT');
            $gross_amount= $net_amount + $net_amount*$tax;
            $order['gross_amount'] = $gross_amount;
            $order->save();

            $username = User::where('id', '=', $request['user_id'])->value('name');

            $orderLog = Orderlog::create(
                ['comment' => "Ihre Bestellung ist eingegangen!",
                    'comment_admin' => "Bestellung vermerkt.",
                    'state' => '0',
                    'username' => $username,
                    'order_id' => $order['id']
                ]
            );

            DB::commit();
            return response()->json($order, 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json('saving order failed' . $e->getMessage(), 420);
        }
    }

    public function updateState (Request $request, string $orderId) : JsonResponse
    {
        DB::beginTransaction();

        try {
            $order = Order::with(['orderlogs'])->where('id', $orderId)->first();
            if ($order != null) {
                $request = $this->parseRequest($request);
                $order->update(['state' => $request['state']]);

                $username = Order::join('users', 'orders.user_id', '=', 'users.id')
                    ->select('users.name')
                    ->where('orders.id', '=', $orderId)
                    ->value('name');


                $orderLog = Orderlog::create(
                    ['comment' => $request['comment'],
                        'comment_admin' => $request['comment_admin'],
                        'state' => $request['state'],
                        'order_id' => $orderId,
                        'username' => $username
                    ]
                );
                $order->save();
            }
            DB::commit();
            return response()->json($order, 201);
        }
        catch (\Exception $e) {
            DB::rollBack();
            return response()->json('updating order failed' . $e->getMessage(), 420);
        }
    }

    private function parseRequest (Request $request) : Request {
        $date = new \DateTime($request->published);
        $request['published'] = $date;
        return $request;
    }
}