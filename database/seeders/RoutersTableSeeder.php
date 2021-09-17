<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RoutersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('routers')->delete();
        
        \DB::table('routers')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'mikrotik-hotspot',
                'ip_device' => '192.168.1.1',
                'username' => 'admin',
                'password' => 'admin',
                'hotspot_name' => 'MikroTik-hotspot',
                'dns_name' => 'voucher.wifi',
                'created_at' => '2021-09-17 17:08:09',
                'updated_at' => '2021-09-17 17:09:36',
            ),
        ));
        
        
    }
}