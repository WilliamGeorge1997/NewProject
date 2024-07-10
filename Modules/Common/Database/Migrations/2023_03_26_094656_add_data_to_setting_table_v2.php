<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Modules\Common\Entities\Setting;

class AddDataToSettingTablev2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('settings')->truncate();
        DB::statement("INSERT INTO `settings` (`key`, `display`, `value`, `type`)
            VALUES
             ('name' , 'الاسم', 'Ashrab','text'),
             ('email' ,'البريد الالكتروني', 'ashrabapp2030@gmail.com','text'),
             ('tax' ,'قيمة الضريبة', '10','text'),
             ('points_value' ,'استبدال 100 نقطة ب', '5','text'),
             ('points_limit' ,'الحد الادني لتحويل النقاط', '500','text'),
             ('terms_ar' ,'الشروط والاحكام باللغة العربية', 'test','textarea'),
             ('terms_en' ,'الشروط والاحكام باللغة الانجليزية', 'test','textarea'),
             ('about_ar' ,'من نحن باللغة العربية', 'test','textarea'),
             ('about_en' ,'من نحن باللغة الانجليزية', 'test','textarea')
             ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('setting', function (Blueprint $table) {

        });
    }
}
