<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Category::class, 15)->create()->each(function($category) {
            factory(App\Product::class, 50)->make()->each(function($product) use(&$category) {
                $category->products()->save($product);

                factory(App\Price::class, 5)->make()->each(function($price) use(&$product) {
                    $product->prices()->save($price);
                });
            });
        });
    }
}
