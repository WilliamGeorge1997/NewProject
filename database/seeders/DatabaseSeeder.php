<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Admin\Database\Seeders\AdminDatabaseSeeder;
use Modules\Order\Database\Seeders\OrderDatabaseSeeder;
use Modules\Service\Database\Seeders\ServiceTableSeeder;
use Modules\Branch\Database\Seeders\BranchDatabaseSeeder;
use Modules\Client\Database\Seeders\ClientDatabaseSeeder;
use Modules\Common\Database\Seeders\CommonDatabaseSeeder;
use Modules\Service\Database\Seeders\ServicDatabaseSeeder;
use Modules\Product\Database\Seeders\ProductDatabaseSeeder;
use Modules\Service\Database\Seeders\ServiceDatabaseSeeder;
use Modules\Service\Database\Seeders\SubServiceTableSeeder;
use Modules\Category\Database\Seeders\CategoryDatabaseSeeder;
use Modules\Employee\Database\Seeders\EmployeeDatabaseSeeder;
use Modules\Provider\Database\Seeders\ProviderDatabaseSeeder;
use Modules\Service\Database\Seeders\SubServiceDatabaseSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(AdminDatabaseSeeder::class);
        // $this->call(ClientDatabaseSeeder::class);
        $this->call(CategoryDatabaseSeeder::class);
        // $this->call(ProductDatabaseSeeder::class);
        $this->call(CommonDatabaseSeeder::class);
        $this->call(ServiceDatabaseSeeder::class);
        $this->call(ProviderDatabaseSeeder::class);
        // $this->call(OrderDatabaseSeeder::class);
        // $this->call(EmployeeDatabaseSeeder::class);
    }
}
