<?php

namespace Modules\Provider\Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Modules\Service\Entities\SubService;

class ProviderDatabaseSeeder extends Seeder
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

        for ($i = 0; $i < 50; $i++) {
            $titleEn = $fakerEn->company;
            $titleAr = $fakerAr->company;

            $descriptionEn = $fakerEn->paragraph;
            $descriptionAr = $fakerAr->paragraph;

            $aboutEn = $fakerEn->paragraph;
            $aboutAr = $fakerAr->paragraph;

            $providerId = DB::table('providers')->insertGetId([
                'title' => json_encode(['en' => $titleEn, 'ar' => $titleAr]),
                'description' => json_encode(['en' => $descriptionEn, 'ar' => $descriptionAr]),
                'about' => json_encode(['en' => $aboutEn, 'ar' => $aboutAr]),
                'category_id' => $fakerEn->numberBetween(1, 20),
                'phone' => $fakerEn->phoneNumber,
                'website' => $fakerEn->url,
                'password' => bcrypt('password'),
                'address' => $fakerEn->address,
                'image' => $fakerEn->imageUrl(),
                'lat' => $fakerEn->latitude,
                'lng' => $fakerEn->longitude,
                'work_on_salon' => $fakerEn->boolean,
                'work_on_home' => $fakerEn->boolean,
                'is_active' => $fakerEn->boolean,
                'is_slider' => $fakerEn->boolean,
                'verify_code' => null,
                'fcm_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);


            $this->seedOpeningTimes($providerId, $fakerEn);


            $this->seedGallery($providerId, $fakerEn);


            $this->seedProviderSubServices($providerId, $fakerEn);
        }
    }

    private function seedOpeningTimes($providerId, $faker)
    {
        $days = ['Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];

        foreach ($days as $day) {
            DB::table('provider_opening_times')->insert([
                'provider_id' => $providerId,
                'day' => $day,
                'open_at' => $faker->time('H:i'),
                'close_at' => $faker->time('H:i'),
                'is_holiday' => $faker->boolean(10),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    private function seedGallery($providerId, $faker)
    {
        for ($j = 0; $j < 5; $j++) {
            DB::table('provider_galleries')->insert([
                'provider_id' => $providerId,
                'image' => $faker->imageUrl(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    private function seedProviderSubServices($providerId, $faker)
    {
        $subServiceIds = SubService::pluck('id')->toArray();

        $selectedSubServices = $faker->randomElements($subServiceIds, $faker->numberBetween(5, 10));

        foreach ($selectedSubServices as $subServiceId) {
            DB::table('provider_service')->insert([
                'provider_id' => $providerId,
                'sub_service_id' => $subServiceId,
            ]);
        }
    }
}
