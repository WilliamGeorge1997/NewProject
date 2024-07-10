<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Modules\Order\Entities\Order;

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
            $table->id();
            $table->json('title');
            $table->json('description');
            $table->string('image')->nullable();
            $table->integer('notifiable_id')->nullable();
            $table->string('notifiable_type');
            $table->foreignIdFor(Order::class)->nullable()->index()->constrained()->cascadeOnDelete();
            $table->timestamp('read_at')->nullable();

            $table->timestamps();
        });

        DB::statement("INSERT INTO `permissions` (`name`, `guard_name`, `category`, `display`) 
            VALUES
             ('Index-notification' , 'admin', 'Notification', 'Index'),
             ('Create-notification' , 'admin', 'Notification', 'Create')
             ");
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
