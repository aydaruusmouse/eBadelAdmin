<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalletsProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallets_profiles', function (Blueprint $table) {
            $table->id('Wallet_Id');
            $table->string('Wallet_Name')->nullable();
            $table->string('Wallet_Provider')->nullable();
            $table->string('Wallet_Type')->nullable();
            $table->string('Wallet_Logo')->nullable();
            $table->string('Merchant_Number')->nullable();
            $table->enum('Status', ['active', 'inactive'])->nullable();
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wallets_profile');
    }
}
