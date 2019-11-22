<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            //
            $table->bigIncrements('id');
            $table->string('products');
            $table->string('descr');
            $table->string('photo');
            $table->string('Tags');
            $table->integer('price');
            $table->integer('count');
            $table->string('status')->default('Y');
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
        Schema::dropIfExists('products');
        // Schema::table('products', function (Blueprint $table) {
        //     //
        //     $table->bigIncrements('id');
        //     $table->string('products');
        //     $table->string('descr');
        //     $table->string('photo');
        //     $table->integer('price');
        //     $table->integer('count');
        //     $table->string('status')->default('Y');
        //     $table->timestamps();
        // });
    }
}
