<?php

use Illuminate\Database\Seeder;
use App\Brands;

class BrandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $brandRecords =
        [
            [
                'id' => 1,
                'name' => 'Bloods',
                'status' => 1
            ],
            [
                'id' => 2,
                'name' => 'Erigo',
                'status' => 1
            ],
            [
                'id' => 3,
                'name' => 'Damn !',
                'status' => 1
            ],
            [
                'id' => 4,
                'name' => 'Levis',
                'status' => 1
            ],
            [
                'id' => 5,
                'name' => 'Parsley',
                'status' => 1
            ]
        ];
        Brands::insert($brandRecords);
    }
}
