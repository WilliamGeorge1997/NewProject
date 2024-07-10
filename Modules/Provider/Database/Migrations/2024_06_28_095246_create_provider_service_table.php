<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Provider\Entities\Provider;
use Modules\Service\Entities\Service;

class CreateProviderServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provider_service', function (Blueprint $table) {
            $table->foreignIdFor(Provider::class)->index()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(\Modules\Service\Entities\SubService::class)->index()->constrained()->cascadeOnDelete();
            $table->tinyInteger('price')->default(30);
            $table->tinyInteger('duration')->default(30);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('provider_service');
    }
}
