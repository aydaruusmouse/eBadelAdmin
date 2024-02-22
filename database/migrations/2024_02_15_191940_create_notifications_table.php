 <?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
 { 
    /**
     * Run the migrations.
     *
      * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id('Notification_Id');
            $table->enum('Notification_Type', ['type1', 'type2', 'type3'])->nullable();
            $table->integer('Recipient_Id')->nullable();
            $table->integer('Related_Entity_Id')->nullable();
            $table->string('Action_Link')->nullable();
            $table->string('Subject')->nullable();
            $table->string('Message')->nullable();
            $table->dateTime('Timestamp')->nullable();
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
        Schema::dropIfExists('notifications');
    }
}
