<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AdminConfigTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('admin_config')->delete();
        
        \DB::table('admin_config')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'active_router',
                'value' => 'mikrotik-hotspot',
                'description' => 'Pilih router yang akan digunakan',
                'created_at' => '2021-09-17 18:14:47',
                'updated_at' => '2021-09-17 18:14:47',
            ),
        ));
        
        
    }
}