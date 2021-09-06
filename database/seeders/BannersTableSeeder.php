<?php

use Illuminate\Database\Seeder;
use App\Banners;

class BannersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bannersRecord = [
            [
                'id' => 1,
                'image' => 'banner1.png',
                'link' => '',
                'title' => 'Black Jacket',
                'alt' => 'Black Jacket',
                'status' => 1
            ],
            [
                'id' => 2,
                'image' => 'banner2.png',
                'link' => '',
                'title' => 'Half Sleeve T-Shirt',
                'alt' => 'Half Sleeve T-Shirt',
                'status' => 1
            ],
            [
                'id' => 3,
                'image' => 'banner3.png',
                'link' => '',
                'title' => 'Long Sleeve T-Shirt',
                'alt' => 'Long Sleeve T-Shirt',
                'status' => 1
            ]
        ];
        Banners::insert($bannersRecord);
    }
}
