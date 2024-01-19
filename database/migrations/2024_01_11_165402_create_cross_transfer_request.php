<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrossTransferRequest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cross_transfer_request', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('sender_wallet_number');
            $table->string('receiver_wallet_number');
            $table->string('amount');
            $table->string('status')->default('initial');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cross_transfer_request');
    }
}
