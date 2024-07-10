<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Entities\Admin;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //        Model::unguard();

        $admin = $this->adminCreation();
        // $admin2 = $this->admin2Creation();
        $permissions = $this->permissionCreation();
        $role = $this->roleCreation();
//         $role2 = $this->role2Creation();
        $admin->assignRole($role);
//        $this->role3Creation();
        // $admin2->assignRole($role2);
        // $this->call("OthersTableSeeder");
    }

    function adminCreation()
    {
        return $admin =  Admin::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('123456789'),
            'phone' => '1235464654'
        ]);
    }

    // function admin2Creation (){
    //     return $admin =  Admin::create([
    //         'name' => 'osama',
    //         'email' => 'osama@osama.com',
    //         'password' => bcrypt('123456789'),
    //         'phone' => '12354654654'
    //     ]);

    // }

    function permissionCreation()
    {
        $permissions = [
            ['Index-admin', 'Admin', 'Index'],
            ['Create-admin', 'Admin', 'Create'],
            ['Edit-admin', 'Admin', 'Edit'],
            ['Delete-admin', 'Admin', 'Delete'],

            ['Index-role', 'Roles', 'Index'],
            ['Create-role', 'Roles', 'Create'],
            ['Edit-role', 'Roles', 'Edit'],
            ['Delete-role', 'Roles', 'Delete'],

            ['Index-client', 'Client', 'Index'],
            ['Create-client', 'Client', 'Create'],
            ['Edit-client', 'Client', 'Edit'],
            ['Delete-client', 'Client', 'Delete'],


            ['Index-category', 'Category', 'Index'],
            ['Create-category', 'Category', 'Create'],
            ['Edit-category', 'Category', 'Edit'],
            ['Delete-category', 'Category', 'Delete'],

            ['Index-provider', 'Provider', 'Index'],
            ['Create-provider', 'Provider', 'Create'],
            ['Edit-provider', 'Provider', 'Edit'],
            ['Delete-provider', 'Provider', 'Delete'],

            ['Index-service', 'Service', 'Index'],
            ['Create-service', 'Service', 'Create'],
            ['Edit-service', 'Service', 'Edit'],
            ['Delete-service', 'Service', 'Delete'],

            ['Index-coupon', 'Coupon', 'Index'],
            ['Create-coupon', 'Coupon', 'Create'],
            ['Edit-coupon', 'Coupon', 'Edit'],
            ['Delete-coupon', 'Coupon', 'Delete'],


            ['Index-setting', 'setting', 'Index'],
            ['Create-setting', 'setting', 'Create'],
            ['Edit-setting', 'setting', 'Edit'],
            ['Delete-setting', 'setting', 'Delete'],

            ['Index-orderstatus', 'orderstatus', 'Index'],
            ['Create-orderstatus', 'orderstatus', 'Create'],
            ['Edit-orderstatus', 'orderstatus', 'Edit'],
            ['Delete-orderstatus', 'orderstatus', 'Delete'],

            ['Index-order', 'order', 'Index'],
            ['Edit-order', 'order', 'Edit'],

            ['Index-log', 'log', 'Index'],


            ['Index-report', 'Report', 'Index'],
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission[0], 'category' => $permission[1], 'guard_name' => 'admin', 'display' => $permission[2]]);
        }
    }

    function roleCreation()
    {
        $role = Role::create(['name' => 'Super Admin', 'guard_name' => 'admin']);
        $permissions = Permission::all();
        $role->syncPermissions($permissions);
        return $role;
    }

     function role2Creation(){
         $role = Role::create(['name' => 'Company Admin','guard_name' => 'admin']);
         return $role;
     }
     function role3Creation(){
         $role = Role::create(['name' => 'Branch Manager','guard_name' => 'admin']);
         return $role;
     }
}
