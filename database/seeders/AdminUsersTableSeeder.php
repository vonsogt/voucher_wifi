<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AdminUsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('admin_users')->delete();
        
        \DB::table('admin_users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'username' => 'admin',
                'password' => '$2y$10$8itMlxVnvpt2TJBfKhSwGOTDmjc/sGkRnEsMhQY0nXg6N70iuCew2',
                'name' => 'Administrator',
                'avatar' => NULL,
                'remember_token' => 'lmJdsK6Q3YGZQfnS6gIXrUG8xbpdPysVZ1VErVXS1BFpRTNb6xE8WMUjWges',
                'created_at' => '2021-09-10 08:31:47',
                'updated_at' => '2021-09-10 08:31:47',
            ),
        ));
        
        
    }
}