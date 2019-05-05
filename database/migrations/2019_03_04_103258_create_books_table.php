<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
        $table->increments('id');
        $table->string('isbn')->unique();
        $table->string('title');
        $table->string('subtitle')->nullable();
        $table->string('published')->nullable();
        $table->integer('rating')->default('1');
        $table->text('description')->nullable();
        $table->decimal('price');
        //foreign kex for user table, hier brauchen wir kein cascading weil user ja nicht gelöscht werden soll wen es keine bücher gibt

            $table->integer('user_id')->unsigned();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
}
