<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AdminMenuTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('admin_menu')->delete();
        
        \DB::table('admin_menu')->insert(array (
            0 => 
            array (
                'id' => 1,
                'parent_id' => 0,
                'order' => 1,
                'title' => 'Dasbor',
                'icon' => 'fa-bar-chart',
                'uri' => '/',
                'permission' => NULL,
                'created_at' => NULL,
                'updated_at' => '2021-09-10 15:38:38',
            ),
            1 => 
            array (
                'id' => 2,
                'parent_id' => 0,
                'order' => 5,
                'title' => 'Admin',
                'icon' => 'fa-tasks',
                'uri' => '',
                'permission' => NULL,
                'created_at' => NULL,
                'updated_at' => '2021-09-17 16:51:14',
            ),
            2 => 
            array (
                'id' => 3,
                'parent_id' => 2,
                'order' => 6,
                'title' => 'Users',
                'icon' => 'fa-users',
                'uri' => 'auth/users',
                'permission' => NULL,
                'created_at' => NULL,
                'updated_at' => '2021-09-17 16:51:14',
            ),
            3 => 
            array (
                'id' => 4,
                'parent_id' => 2,
                'order' => 7,
                'title' => 'Roles',
                'icon' => 'fa-user',
                'uri' => 'auth/roles',
                'permission' => NULL,
                'created_at' => NULL,
                'updated_at' => '2021-09-17 16:51:14',
            ),
            4 => 
            array (
                'id' => 5,
                'parent_id' => 2,
                'order' => 8,
                'title' => 'Permission',
                'icon' => 'fa-ban',
                'uri' => 'auth/permissions',
                'permission' => NULL,
                'created_at' => NULL,
                'updated_at' => '2021-09-17 16:51:14',
            ),
            5 => 
            array (
                'id' => 6,
                'parent_id' => 2,
                'order' => 9,
                'title' => 'Menu',
                'icon' => 'fa-bars',
                'uri' => 'auth/menu',
                'permission' => NULL,
                'created_at' => NULL,
                'updated_at' => '2021-09-17 16:51:14',
            ),
            6 => 
            array (
                'id' => 7,
                'parent_id' => 2,
                'order' => 10,
                'title' => 'Operation log',
                'icon' => 'fa-history',
                'uri' => 'auth/logs',
                'permission' => NULL,
                'created_at' => NULL,
                'updated_at' => '2021-09-17 16:51:14',
            ),
            7 => 
            array (
                'id' => 8,
                'parent_id' => 0,
                'order' => 2,
                'title' => 'Paket',
                'icon' => 'fa-cubes',
                'uri' => '/packages',
                'permission' => 'admin.packages',
                'created_at' => '2021-09-10 15:46:58',
                'updated_at' => '2021-09-17 16:54:18',
            ),
            8 => 
            array (
                'id' => 9,
                'parent_id' => 0,
                'order' => 3,
                'title' => 'Voucher',
                'icon' => 'fa-credit-card',
                'uri' => 'vouchers',
                'permission' => 'admin.vouchers',
                'created_at' => '2021-09-10 15:47:21',
                'updated_at' => '2021-09-17 16:54:12',
            ),
            9 => 
            array (
                'id' => 10,
                'parent_id' => 0,
                'order' => 11,
                'title' => 'Helpers',
                'icon' => 'fa-gears',
                'uri' => NULL,
                'permission' => 'ext.helpers',
                'created_at' => '2021-09-10 15:50:24',
                'updated_at' => '2021-09-17 16:51:31',
            ),
            10 => 
            array (
                'id' => 11,
                'parent_id' => 10,
                'order' => 12,
                'title' => 'Scaffold',
                'icon' => 'fa-keyboard-o',
                'uri' => 'helpers/scaffold',
                'permission' => NULL,
                'created_at' => '2021-09-10 15:50:24',
                'updated_at' => '2021-09-17 16:51:14',
            ),
            11 => 
            array (
                'id' => 12,
                'parent_id' => 10,
                'order' => 13,
                'title' => 'Database terminal',
                'icon' => 'fa-database',
                'uri' => 'helpers/terminal/database',
                'permission' => NULL,
                'created_at' => '2021-09-10 15:50:24',
                'updated_at' => '2021-09-17 16:51:14',
            ),
            12 => 
            array (
                'id' => 13,
                'parent_id' => 10,
                'order' => 14,
                'title' => 'Laravel artisan',
                'icon' => 'fa-terminal',
                'uri' => 'helpers/terminal/artisan',
                'permission' => NULL,
                'created_at' => '2021-09-10 15:50:24',
                'updated_at' => '2021-09-17 16:51:14',
            ),
            13 => 
            array (
                'id' => 14,
                'parent_id' => 10,
                'order' => 15,
                'title' => 'Routes',
                'icon' => 'fa-list-alt',
                'uri' => 'helpers/routes',
                'permission' => NULL,
                'created_at' => '2021-09-10 15:50:24',
                'updated_at' => '2021-09-17 16:51:14',
            ),
            14 => 
            array (
                'id' => 15,
                'parent_id' => 0,
                'order' => 16,
                'title' => 'Config',
                'icon' => 'fa-toggle-on',
                'uri' => 'config',
                'permission' => 'ext.config',
                'created_at' => '2021-09-10 16:36:33',
                'updated_at' => '2021-09-17 16:51:25',
            ),
            15 => 
            array (
                'id' => 16,
                'parent_id' => 0,
                'order' => 4,
                'title' => 'Router',
                'icon' => 'fa-hdd-o',
                'uri' => '/routers',
                'permission' => 'admin.routers',
                'created_at' => '2021-09-17 16:50:44',
                'updated_at' => '2021-09-17 16:55:05',
            ),
        ));
        
        
    }
}