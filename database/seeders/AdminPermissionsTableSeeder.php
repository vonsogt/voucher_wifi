<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AdminPermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('admin_permissions')->delete();
        
        \DB::table('admin_permissions')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'All permission',
                'slug' => '*',
                'http_method' => '',
                'http_path' => '*',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Dashboard',
                'slug' => 'dashboard',
                'http_method' => 'GET',
                'http_path' => '/',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Login',
                'slug' => 'auth.login',
                'http_method' => '',
                'http_path' => '/auth/login
/auth/logout',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'User setting',
                'slug' => 'auth.setting',
                'http_method' => 'GET,PUT',
                'http_path' => '/auth/setting',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Auth management',
                'slug' => 'auth.management',
                'http_method' => '',
                'http_path' => '/auth/roles
/auth/permissions
/auth/menu
/auth/logs',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Admin helpers',
                'slug' => 'ext.helpers',
                'http_method' => '',
                'http_path' => '/helpers/*',
                'created_at' => '2021-09-10 15:50:25',
                'updated_at' => '2021-09-10 15:50:25',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Admin Config',
                'slug' => 'ext.config',
                'http_method' => '',
                'http_path' => '/config*',
                'created_at' => '2021-09-10 16:36:33',
                'updated_at' => '2021-09-10 16:36:33',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'Packages',
                'slug' => 'admin.packages',
                'http_method' => '',
                'http_path' => '/packages*',
                'created_at' => '2021-09-17 16:52:36',
                'updated_at' => '2021-09-17 16:53:05',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'Vouchers',
                'slug' => 'admin.vouchers',
                'http_method' => '',
                'http_path' => '/vouchers*',
                'created_at' => '2021-09-17 16:53:23',
                'updated_at' => '2021-09-17 16:53:23',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'Routers',
                'slug' => 'admin.routers',
                'http_method' => '',
                'http_path' => '/routers*',
                'created_at' => '2021-09-17 16:53:48',
                'updated_at' => '2021-09-17 16:53:48',
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'Logs',
                'slug' => 'ext.log-viewer',
                'http_method' => '',
                'http_path' => '/logs*',
                'created_at' => '2021-09-22 15:36:37',
                'updated_at' => '2021-09-22 15:36:37',
            ),
        ));
        
        
    }
}