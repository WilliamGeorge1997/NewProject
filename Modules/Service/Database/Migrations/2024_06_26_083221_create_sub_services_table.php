<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_services', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\Modules\Service\Entities\Service::class)->index()->constrained()->cascadeOnDelete();
            $table->json('title');
            $table->boolean('is_active')->default(1);
            $table->integer('order')->default(1);
            $table->string('image')->nullable();
            $table->unsignedTinyInteger('duration')->default(30);
            $table->unsignedTinyInteger('price')->default(0);
            $table->boolean('range')->default(0);
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
        Schema::dropIfExists('sub_services');
    }
}
