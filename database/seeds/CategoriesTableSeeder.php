<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $categoreis=['cat one','cat two','cat three'];
        foreach ($categoreis as $category) {
            \App\Category::create([
            'ar'=> ['name'=>$category],
            'en'=> ['name'=>$category],
        ]);
        }

    }
}
