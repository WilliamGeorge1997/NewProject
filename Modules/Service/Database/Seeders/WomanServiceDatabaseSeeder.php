<?php

namespace Modules\Service\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use File;
use Modules\Category\Entities\Category;
use Modules\Service\Entities\Service;

class WomanServiceDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $json = File::get(database_path('json/services_woman.json'));
        // $data = json_decode($json);
        // $countRecords = count($data);
        // $this->command->getOutput()->progressStart($countRecords);
        // $count = 1;
        // foreach ($data as $category) {
        //     $newCategory = Category::create([
        //         'title' => ['en'=>$category->name_en,"ar"=>$category->name_ar],
        //         'order' => $count,
        //         'type' => $category->type
        //     ]);
        //     $services = $category->services;
        //     $countservices = 1;
        //     foreach ($services as $service) {
        //         Service::create([
        //             'title' => ['en'=>$service->name_en,"ar"=>$service->name_ar],
        //             'category_id' => $newCategory->id,
        //             'price_from' => $service->price_from,
        //             'price_to' => $service->price_to,
        //             'type' => $service->type
        //         ]);
        //         $countservices++;
        //     }
        //     $count++;
        //     $this->command->getOutput()->progressAdvance();
        // }

        // $this->command->getOutput()->progressFinish();
        // $this->command->info('Seeded Women Services!');
    }
}
