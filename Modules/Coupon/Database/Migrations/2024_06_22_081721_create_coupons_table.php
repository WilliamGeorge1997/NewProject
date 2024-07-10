<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->boolean('is_active')->default(1);
            $table->integer('num_of_uses');
            $table->integer('counter')->default(0);
            $table->tinyInteger('type');
            $table->integer('value');
            $table->integer('limit')->default(0);
            $table->date('date_from')->nullable();
            $table->date('date_to')->nullable();
            $table->time('time_from')->nullable();
            $table->time('time_to')->nullable();
            $table->integer('client_uses')->default(1);
            $table->string('discount_on')->nullable()->comment('1 => subtotal, 2 => delivery fee, 3 => both ');

            $table->timestamps();
        });

        Schema::create('coupon_provider', function (Blueprint $table) {
            $table->foreignIdFor(\Modules\Coupon\Entities\Coupon::class)->index()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(\Modules\Provider\Entities\Provider::class)->index()->constrained()->cascadeOnDelete();
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
        Schema::dropIfExists('coupons');
    }
}
