<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPrivacyToSetting extends Migration
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
            (NULL, 'privacy_policy_ar', 'سياسة الخصوصية باللغة العربية', 0,'textarea'),
            (NULL, 'privacy_policy_en', 'سياسة الخصوصية باللغة الانجليزية', 0,'textarea'),
            (NULL, 'refund_ar', 'سياسة الاسترجاع باللغة الانجليزية', 0,'textarea'),
            (NULL, 'refund_en', 'سياسة الاسترجاع باللغة الانجليزية', 0,'textarea')
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
