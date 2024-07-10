<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->id();
            $table->string('order_no');
            $table->unsignedFloat('subtotal')->default(0);
            $table->unsignedFloat('discount')->default(0);
            $table->tinyInteger('discount_type')->index()->nullable();
            $table->unsignedFloat('tax')->default(0);
            $table->unsignedFloat('total')->default(0);
            $table->unsignedInteger('quantity')->default(0);
            $table->date('reservation_date');
            $table->time('reservation_time');
            $table->string('notes')->nullable();
            $table->text('address')->nullable();
            $table->tinyInteger('place')->default(0)->comment('0=>salon | 1=>home');
            $table->foreignIdFor(\Modules\Client\Entities\Client::class)->index()->constrained()->restrictOnDelete();
            $table->foreignIdFor(\Modules\Provider\Entities\Provider::class)->index()->constrained()->restrictOnDelete();
            $table->foreignIdFor(\Modules\Order\Entities\OrderStatus::class)->index()->nullable()->constrained()->restrictOnDelete();
            $table->foreignIdFor(\Modules\Coupon\Entities\Coupon::class)->nullable()->index()->constrained()->nullOnDelete();
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
        Schema::dropIfExists('orders');
    }
}
