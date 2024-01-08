<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('transaction')) {
            Schema::create('transaction', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->string('sender');
                $table->string('recipient');
                $table->string('amount');
                $table->string('paymentStatus');
                $table->string('apiResponseMessage');
                $table->string('recipient_phone');
                $table->date('date');
                $table->time('time');
                $table->uuid('reference_id');
                $table->uuid('transaction_id')->primary(); 
            });
        }
    }
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction');
    }
}
