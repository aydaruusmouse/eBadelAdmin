 <?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
 {
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
        Schema::create('orders', function (Blueprint $table) {
            $table->id('Order_Id');
            $table->integer('User_Profile_Id')->nullable();
            $table->string('Origin_Wallet')->nullable();
            $table->string('Destination_Wallet')->nullable();
            $table->string('Sender_Account')->nullable();
            $table->string('Recipient_Account')->nullable();
            $table->string('Origin_Currency')->nullable();
            $table->string('Destination_Currency')->nullable();
            $table->double('Amount')->nullable();
            $table->double('Bridge_Fee')->nullable();
            $table->string('Debit_Response')->nullable();
            $table->string('Credit_Response')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
