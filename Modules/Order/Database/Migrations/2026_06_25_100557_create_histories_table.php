<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Client\Entities\Client;
use Modules\Order\Entities\Order;
use Modules\Order\Entities\OrderStatus;

class CreateHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('histories', function (Blueprint $table) {
            $table->id();
            $table->string('notes')->nullable();
            $table->foreignIdFor(OrderStatus::class)->index()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Order::class)->index()->constrained()->cascadeOnDelete();
            $table->integer('historible_id');
            $table->string('historible_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('histories');
    }
}
