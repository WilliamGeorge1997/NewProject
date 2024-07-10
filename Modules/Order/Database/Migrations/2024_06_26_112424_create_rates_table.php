<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Branch\Entities\Branch;
use Modules\Client\Entities\Client;
use Modules\Driver\Entities\Driver;
use Modules\Order\Entities\Order;

class CreateRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rates', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\Modules\Provider\Entities\Provider::class)->index()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Order::class)->index()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Client::class)->index()->constrained()->cascadeOnDelete();
            $table->double('provider_rate');
            $table->double('service_rate');
            $table->string('comment')->nullable();
            $table->unique(['order_id', 'provider_id','client_id']);

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
        Schema::dropIfExists('rates');
    }
}
