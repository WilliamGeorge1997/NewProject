<?php

namespace Modules\Service\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Service\Entities\Service;
use Illuminate\Database\Eloquent\Model;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class ServiceDatabaseSeeder extends Seeder
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

        $services = [];
        $subServices = [];

        for ($i = 1; $i <= 20; $i++) {
            $serviceEn = $fakerEn->sentence(2);
            $serviceAr = $fakerAr->sentence(2);

            $services[] = [
                'title' => json_encode(['en' => $serviceEn, 'ar' => $serviceAr]),
                'is_active' => true,
                'order' => $i,
                'category_id' => $fakerEn->numberBetween(1, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('services')->insert($services);
        $servicesFromDB = DB::table('services')->get();

        foreach ($servicesFromDB as $service) {
            $serviceId = $service->id;
            for ($i = 1; $i <= 30; $i++) {
                $subServiceEn = $fakerEn->words(3, true);
                $subServiceAr = $fakerAr->words(3, true);

                $subServices[] = [
                    'service_id' => $serviceId,
                    'title' => json_encode(['en' => $subServiceEn, 'ar' => $subServiceAr]),
                    'is_active' => true,
                    'order' => $i,
                    'image' => $fakerEn->imageUrl(),
                    'duration' => $fakerEn->numberBetween(15, 120),
                    'price' => $fakerEn->numberBetween(10, 100),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }


        DB::table('sub_services')->insert($subServices);
    }
}
