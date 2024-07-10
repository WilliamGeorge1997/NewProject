<?php

namespace Modules\Common\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Common\Entities\Setting;

class CommonDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $data = [
            ['key' => 'name', 'display' => 'الاسم', 'value' => 'Shop', 'type' => 'text'],
            ['key' => 'email', 'display' => 'البريد الالكتروني', 'value' => 'loz_moz@gmail.com', 'type' => 'text'],
            ['key' => 'tax', 'display' => 'قيمة الضريبة', 'value' => '10', 'type' => 'text'],
            ['key' => 'points_value', 'display' => 'استبدال 100 نقطة ب', 'value' => '5', 'type' => 'text'],
            ['key' => 'points_limit', 'display' => 'الحد الادني لتحويل النقاط', 'value' => '500', 'type' => 'text'],
            ['key' => 'terms_ar', 'display' => 'الشروط والاحكام باللغة العربية', 'value' => '', 'type' => 'textarea'],
            ['key' => 'terms_en', 'display' => 'الشروط والاحكام باللغة الانجليزية', 'value' => '', 'type' => 'textarea'],
            ['key' => 'about_ar', 'display' => 'من نحن باللغة العربية', 'value' => '', 'type' => 'textarea'],
            ['key' => 'about_en', 'display' => 'من نحن باللغة الانجليزية', 'value' => '', 'type' => 'textarea'],
        ];
        Setting::query()->insert($data);

        // $this->call("OthersTableSeeder");
    }
}
