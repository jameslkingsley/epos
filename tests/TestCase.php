<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication,
        DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        $this->basket = basket();
    }
}
