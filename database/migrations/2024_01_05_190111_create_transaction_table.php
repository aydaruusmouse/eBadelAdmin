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
                $table->unsignedBigInteger('user_id'); // Foreign key
                $table->foreign('user_id')->references('id')->on('users');
                $table->string('wallet_type');
                $table->string('Order_id')->default(''); 
                $table->string('senders_wallet_name');
                $table->string('receivers_wallet_name');
                $table->string('senders_account_number');
                $table->string('receivers_account_number');
                $table->string('senders_account_name');
                $table->string('receivers_account_name');
                $table->string('currencies');
                $table->string('swap_fee');
                $table->string('excuted_by');
                $table->string('amount');
                $table->string('status');
                $table->string('debit_Message');
                $table->string('credit_response');
                $table->uuid('transaction_id'); 
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
