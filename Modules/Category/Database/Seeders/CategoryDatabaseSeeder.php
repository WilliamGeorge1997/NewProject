<?php

namespace Modules\Category\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Category\Entities\Category;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class CategoryDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
         $fakerEn = Faker::create('en_US');
        $fakerAr = Faker::create('ar_SA');

        for ($i = 0; $i < 20; $i++) {
            $title = [
                'en' => $fakerEn->words(3, true),
                'ar' => $fakerAr->words(3, true),
            ];

            DB::table('categories')->insert([
                'title' => json_encode($title),
                'is_active' => $fakerEn->boolean(90),
                'image' => $fakerEn->imageUrl(),
                'order' => $fakerEn->numberBetween(1, 100),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
