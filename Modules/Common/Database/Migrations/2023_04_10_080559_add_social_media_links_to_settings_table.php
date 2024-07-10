<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSocialMediaLinksToSettingsTable extends Migration
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
            (NULL, 'phone', 'رقم الهاتف', null,'text'),
            (NULL, 'facebook', 'فيس بوك', null,'text'),
            (NULL, 'whatsapp', 'واتس اب', null,'text'),
            (NULL, 'instagram', 'انستجرام', null,'text'),
            (NULL, 'twitter', 'تويتر', null,'text')
");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {

        });
    }
}
