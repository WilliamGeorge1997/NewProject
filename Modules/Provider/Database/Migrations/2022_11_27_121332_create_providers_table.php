<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Country\Entities\Area;
use Modules\Country\Entities\City;
use Modules\Country\Entities\Country;

class CreateProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('providers', function (Blueprint $table) {
            $table->id();
            $table->json('title');
            $table->json('description');
            $table->json('about')->nullable();
            $table->foreignIdFor(\Modules\Category\Entities\Category::class)->index()->constrained()->cascadeOnDelete();
            $table->string('phone');
            $table->string('website')->nullable();
            $table->string('password');
            $table->text('address');
            $table->string('image')->nullable();
            $table->string('lat');
            $table->string('lng');
            $table->boolean('work_on_salon')->default(1);
            $table->boolean('work_on_home')->default(1);
            $table->boolean('is_active')->default(1);
            $table->boolean('is_slider')->default(0);
            $table->string('verify_code')->nullable();
            $table->string('fcm_token')->nullable();

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
        Schema::dropIfExists('providers');
    }
}
