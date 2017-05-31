<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Basket\Models\Deal;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DealTest extends TestCase
{
    /** @test */
    public function can_add_deal_to_basket()
    {
        $deal = Deal::first();

        $this->basket->deals->add($deal);

        $this->assertTrue($this->basket->deals->has($deal));
    }
}
