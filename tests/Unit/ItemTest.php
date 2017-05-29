<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Basket\Models\Item;
use App\Basket\Support\Number;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ItemTest extends TestCase
{
    /** @test */
    public function can_add_item_to_basket()
    {
        $item = Item::first();

        $this->basket->items->add($item);

        $this->assertTrue($this->basket->items->has($item));
    }

    /** @test */
    public function can_add_many_items_to_basket()
    {
        $item = Item::first();

        $this->basket->items->addMany($item, 10);

        $this->assertEquals(10, $this->basket->items->count());
    }

    /** @test */
    public function can_remove_one_item_from_basket()
    {
        $item = Item::first();

        $this->basket->items->add($item);
        $this->basket->items->remove($item, 1);

        $this->assertTrue($this->basket->items->isEmpty());
    }

    /** @test */
    public function can_remove_many_items_from_basket()
    {
        $item = Item::first();

        $this->basket->items->addMany($item, 5);
        $this->basket->items->remove($item, 3);

        $this->assertEquals(2, $this->basket->items->count());
    }

    /** @test */
    public function can_update_item_in_basket()
    {
        $item = Item::first();

        $this->basket->items->add($item);

        $this->basket->items->update($item, function(&$item) {
            $item->model_type = 'model_type_changed';
        });

        $this->assertEquals('model_type_changed', $this->basket->items->first()->model_type);
    }

    /** @test */
    public function can_get_count_of_items()
    {
        $count = $this->basket->items->count();

        $this->assertInternalType('int', $count);
    }

    /** @test */
    public function can_check_item_is_in_basket()
    {
        $item = Item::first();

        $this->basket->items->add($item);

        $this->assertTrue($this->basket->items->has($item));
    }

    /** @test */
    public function can_get_balance_of_items()
    {
        $this->assertInstanceOf(Number::class, $this->basket->items->balance());
    }
}
