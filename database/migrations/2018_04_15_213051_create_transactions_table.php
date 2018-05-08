<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date')->useCurrent();
            $table->boolean('confirmed')->default(false);
            $table->string('description');
            $table->double('value', 10, 2)->default(0);
            $table->timestamps();
            $table
                ->integer('source_account_id')
                ->unsigned();
            $table
                ->integer('destination_account_id')
                ->unsigned();
            $table
                ->foreign('source_account_id')
                ->references('id')
                ->on('accounts')
                ->onDelete('cascade');
            $table
                ->foreign('destination_account_id')
                ->references('id')
                ->on('accounts')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
