<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDeliveryFeeToSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Illuminate\Support\Facades\DB::statement(
            "INSERT INTO `settings`
             (`id`, `key`, `display`, `value`, `type`)
              VALUES
            (NULL, 'today_fee', 'تكلفة التوصيل في نفس اليوم', 0,'text'),
            (NULL, 'next_day_fee', 'تكلفة التوصيل في اليوم التالي', 0,'text')
");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('', function (Blueprint $table) {

        });
    }
}
