<?php

namespace Tests\Unit;

use Tests\TestCase;
use Tests\TestEvent;
use App\Basket\Basket;
use App\Basket\Models\Balance;
use App\Basket\Models\Summary;
use App\Basket\Collections\ItemCollection;
use App\Basket\Collections\PaymentCollection;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BasketTest extends TestCase
{
    /** @test */
    public function items_is_item_collection()
    {
        $this->assertInstanceOf(ItemCollection::class, $this->basket->items);
    }

    /** @test */
    public function payments_is_payment_collection()
    {
        $this->assertInstanceOf(PaymentCollection::class, $this->basket->payments);
    }

    /** @test */
    public function summaries_is_summary_instance()
    {
        $this->assertInstanceOf(Summary::class, $this->basket->summaries);
    }

    /** @test */
    public function summaries_balance_is_balance_instance()
    {
        $this->assertInstanceOf(Balance::class, $this->basket->summaries->balance);
    }

    /** @test */
    public function can_empty_basket()
    {
        $basket = $this->basket->empty();

        $this->assertInstanceOf(Basket::class, $basket);
    }

    /** @test */
    public function can_get_basket()
    {
        $basket = $this->basket->get();

        $this->assertInstanceOf(Basket::class, $basket);
    }

    /** @test */
    public function can_update_basket_without_events()
    {
        $basket = $this->basket->update(function($basket) {
            return $basket;
        });

        $this->assertInstanceOf(Basket::class, $basket);
    }

    /** @test */
    public function can_update_basket_with_events()
    {
        $basket = $this->basket->update(function($basket) {
            return $basket->withEvent(TestEvent::class, []);
        });

        $this->assertInstanceOf(Basket::class, $basket);
    }
}
