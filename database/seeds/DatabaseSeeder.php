<?php

use Carbon\Carbon;
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
        factory(App\Basket\Models\Category::class, 6)->create()->each(function($category) {
            factory(App\Product::class, 16)->create()->each(function($product) use(&$category) {
                $item = App\Basket\Models\Item::forceCreate([
                    'model_id' => $product->id,
                    'model_type' => get_class($product),
                    'category_id' => $category->id
                ]);

                factory(App\Basket\Models\Price::class, 4)->make()->each(function($price) use(&$product) {
                    $price->model_type = get_class($product);
                    $price->model_id = $product->id;
                    $price->save();
                });
            });
        });

        foreach ([
            'Generic' => 'App\\Basket\\Printers\\Generic',
            'Star Web Print' => 'App\\Basket\\Printers\\StarWebPrint'
        ] as $key => $value) {
            App\Basket\Models\Printer::forceCreate([
                'name' => $key,
                'provider_class' => $value
            ]);
        }

        foreach ([
            'Cash' => 'App\\Basket\\Payments\\Cash',
            'Card' => 'App\\Basket\\Payments\\Card',
            'Fast Cash' => 'App\\Basket\\Payments\\FastCash',
            'Fast Card' => 'App\\Basket\\Payments\\FastCard'
        ] as $key => $value) {
            App\Basket\Models\Payment::forceCreate([
                'name' => $key,
                'handler' => $value
            ]);
        }

        foreach ([
            'Buy One Get One Free' => 'App\\Basket\\Deals\\BuyOneGetOneFree',
            'Buy One Get One Half Price' => 'App\\Basket\\Deals\\BuyOneGetOneHalfPrice'
        ] as $key => $value) {
            $deal = App\Basket\Models\Deal::forceCreate([
                'name' => $key,
                'handler_class' => $value,
                'starts_at' => Carbon::create(2000, 1, 1, 12, 0, 0),
                'ends_at' => Carbon::create(3000, 1, 1, 12, 0, 0)
            ]);

            foreach (range(1, 5) as $index) {
                $deal->items()->create([
                    'item_id' => App\Basket\Models\Item::inRandomOrder()->first()->id
                ]);
            }
        }
    }
}
