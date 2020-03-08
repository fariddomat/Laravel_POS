<?php

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
          
        $products=['pro one','pro two','pro three'];
        foreach ($products as $product) {
            \App\Product::create([
                'category_id'=>1,
                'ar'=> ['name'=>$product,'description'=>'desc'],
                'en'=> ['name'=>$product,'description'=>'desc'],
                'purchase_price'=>100,
                'sale_price'=>120,
                'stock'=>20,
        ]);
        }
    }
}
