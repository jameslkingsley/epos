<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CategoryTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->category = factory('App\Category')->create();
    }

    /** @test */
    public function placeholder()
    {
        $this->assertTrue(true);
    }
}
