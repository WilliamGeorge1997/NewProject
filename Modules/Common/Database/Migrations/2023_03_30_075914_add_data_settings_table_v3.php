<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDataSettingsTablev3 extends Migration
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
            (NULL, 'before_repeat_days', 'عدد الايام قبل ارسال تنبية التكرار', 3 ,'text')
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
