<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PackagesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('packages')->delete();

        \DB::table('packages')->insert(array (
            0 =>
            array (
                'id' => 1,
                'name' => '12 Jam',
                'price' => 5000,
                'notes' => NULL,
                'created_at' => '2021-09-10 16:44:38',
                'updated_at' => '2021-09-10 16:44:38',
            ),
            1 =>
            array (
                'id' => 2,
                'name' => '1 Minggu',
                'price' => 20000,
                'notes' => NULL,
                'created_at' => '2021-09-10 16:44:52',
                'updated_at' => '2021-09-10 16:44:52',
            ),
            2 =>
            array (
                'id' => 3,
                'name' => '1 Bulan',
                'price' => 50000,
                'notes' => NULL,
                'created_at' => '2021-09-10 16:45:04',
                'updated_at' => '2021-09-10 16:45:04',
            ),
            3 =>
            array (
                'id' => 4,
                'name' => '6 Bulan',
                'price' => 140000,
                'notes' => NULL,
                'created_at' => '2021-09-10 17:16:09',
                'updated_at' => '2021-09-10 17:16:09',
            ),
            4 =>
            array (
                'id' => 5,
                'name' => '12 Bulan',
                'price' => 250000,
                'notes' => NULL,
                'created_at' => '2021-09-10 17:16:24',
                'updated_at' => '2021-09-10 17:16:24',
            ),
        ));


    }
}
