<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->delete();
        $adminRecords = [
            [
                'id' => 1,
                'name' => 'Agung Prabowo',
                'type' => 'admin',
                'mobile' => '08123456901',
                'email' => 'bangprabs@gmail.com',
                'password' =>  bcrypt('agung'),
                'image' => '',
                'status' => 1
            ],
            [
                'id' => 2,
                'name' => 'Rafi Raihan',
                'type' => 'subadmin',
                'mobile' => '08123456901',
                'email' => 'rafi@gmail.com',
                'password' =>  bcrypt('rafi'),
                'image' => '',
                'status' => 1
            ]
        ];

        DB::table('admins')->insert($adminRecords);

        // foreach ($adminRecords  as $key => $record) {
        //     \App\Admin::create($record);
        // }
    }
}
