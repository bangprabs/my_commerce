<?php

use Illuminate\Database\Seeder;
use App\ProductsImages;

class ProductsImagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productsImagesRecords = [
            [
                'id' => 1,
                'product_id' => 1,
                'image' => '22123548 (2).jpg-70065.jpg',
                'status' => 1
            ]
        ];
        ProductsImages::insert($productsImagesRecords);
    }
}
