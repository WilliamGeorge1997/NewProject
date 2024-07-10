<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedFloat('total');
            $table->unsignedFloat('price');
            $table->unsignedInteger('quantity');
            $table->string('note')->nullable();
            $table->foreignIdFor(\Modules\Order\Entities\Order::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(\Modules\Service\Entities\SubService::class)->constrained()->restrictOnDelete();

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
        Schema::dropIfExists('order_details');
    }
}
