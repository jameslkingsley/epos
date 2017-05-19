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
        factory(App\Basket\Models\Category::class, 15)->create()->each(function($category) {
            factory(App\Product::class, 50)->create()->each(function($product) use(&$category) {
                $item = App\Basket\Models\Item::forceCreate([
                    'model_id' => $product->id,
                    'model_type' => get_class($product),
                    'category_id' => $category->id
                ]);

                factory(App\Basket\Models\Price::class, 5)->make()->each(function($price) use(&$product) {
                    $price->model_type = get_class($product);
                    $price->model_id = $product->id;
                    $price->save();
                });
            });
        });
    }
}
