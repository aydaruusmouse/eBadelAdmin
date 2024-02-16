<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBridgeFeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bridge_fee', function (Blueprint $table) {
            $table->id('Bridge_Fee_Id');
            $table->string('Origin_Wallet');
            $table->string('Destination_Wallet');
            $table->string('Origin_Currency');
            $table->string('Destination_Currency');
            $table->double('Fee_Percentage');
            $table->enum('Calculation_Method', ['Percentage-based', 'Flat_fee']);
            $table->enum('Status', ['active', 'inactive']);
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
        Schema::dropIfExists('bridge_fee');
    }
}
