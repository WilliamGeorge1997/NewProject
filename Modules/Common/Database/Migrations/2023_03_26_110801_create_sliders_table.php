<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->json('title');
            $table->json('description');
            $table->string('image');
            $table->boolean('is_active')->default(1);
            $table->timestamps();
        });

        DB::statement("INSERT INTO `permissions` (`name`, `guard_name`, `category`, `display`) 
            VALUES
             ('Index-slider' , 'admin', 'Slider', 'Index'),
             ('Create-slider' , 'admin', 'Slider', 'Create'),
             ('Edit-slider' , 'admin', 'Slider', 'Edit'),
             ('Delete-slider' , 'admin', 'Slider', 'Delete')
             ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sliders');
    }
}
