<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProviderOpeningTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provider_opening_times', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\Modules\Provider\Entities\Provider::class)->index()->constrained()->cascadeOnDelete();
            $table->enum('day',['Saturday','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday']);
            $table->time('open_at')->nullable();
            $table->time('close_at')->nullable();
            $table->boolean('is_holiday')->default(0);

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
        Schema::dropIfExists('provider_opening_times');
    }
}
