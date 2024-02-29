<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserWalletAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_wallet_accounts', function (Blueprint $table) {
            $table->id('User_Wallet_Account_Id');
            $table->unsignedBigInteger('User_Profile_Id')->nullable();
            $table->integer('Wallet_Id')->nullable();
            // $table->unsignedBigInteger('Wallet_Id')->nullable();
            $table->foreign('User_Profile_Id')->references('User_Profile_Id')->on('user_profiles');
            // $table->foreign('Wallet_Id')->references('Wallet_Id')->on('wallets_profiles');
            $table->enum('Status', ['active', 'inactive'])->nullable();
            $table->string('Account_Number')->nullable();
            $table->string('Account_Name')->nullable();
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
        Schema::dropIfExists('user_wallet_accounts');
    }
}
