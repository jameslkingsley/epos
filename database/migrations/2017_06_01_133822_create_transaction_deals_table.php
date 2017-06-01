<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionDealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_deals', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('discount')->default(0);
            $table->integer('deal_id')->unsigned();
            $table->foreign('deal_id')->references('id')->on('deals')->onDelete('restrict');
            $table->integer('transaction_header_id')->unsigned();
            $table->foreign('transaction_header_id')->references('id')->on('transaction_headers')->onDelete('cascade');
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
        Schema::dropIfExists('transaction_deals');
    }
}
