<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDeliveryTextToSettings extends Migration
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
            (NULL, 'today_delivery_text_ar', 'نص التوصيل اليوم باللغة العربية', 0,'text'),
            (NULL, 'today_delivery_text_en', 'نص التوصيل اليوم باللغة الانجليزية', 0,'text'),
            (NULL, 'tomorrow_delivery_text_ar', 'نص التوصيل غدا باللغة العربية', 0,'text'),
            (NULL, 'tomorrow_delivery_text_en', 'نص التوصيل غدا باللغة الانجليزية', 0,'text')
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
