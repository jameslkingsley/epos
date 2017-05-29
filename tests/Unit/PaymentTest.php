<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Basket\Models\Payment;
use App\Basket\Support\Number;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PaymentTest extends TestCase
{
    /** @test */
    public function can_add_payment_to_basket()
    {
        $payment = Payment::first();

        $this->basket->payments->add($payment);

        $this->assertTrue($this->basket->payments->has($payment));
    }

    /** @test */
    public function can_remove_payment_from_basket()
    {
        $payment = Payment::first();

        $this->basket->payments->add($payment);
        $this->basket->payments->remove($payment);

        $this->assertTrue($this->basket->payments->isEmpty());
    }

    /** @test */
    public function can_update_payment_in_basket()
    {
        $payment = Payment::first();

        $this->basket->payments->add($payment);

        $this->basket->payments->update($payment, function(&$payment) {
            $payment->amount = 1000;
        });

        $this->assertEquals(1000, $this->basket->payments->first()->amount);
    }

    /** @test */
    public function can_remove_all_payments_from_basket()
    {
        $payments = Payment::all()->random(3);

        foreach ($payments as $payment) {
            $this->basket->payments->add($payment);
        }

        $this->basket->payments->empty();

        $this->assertTrue($this->basket->payments->isEmpty());
    }

    /** @test */
    public function can_check_payment_is_in_basket()
    {
        $payment = Payment::first();

        $this->basket->payments->add($payment);

        $this->assertTrue($this->basket->payments->has($payment));
    }

    /** @test */
    public function can_get_balance_of_all_payments()
    {
        $payments = Payment::all()->random(3);

        foreach ($payments as $payment) {
            $payment->amount = rand(100, 1000);
            $this->basket->payments->add($payment);
        }

        $this->assertInstanceOf(Number::class, $this->basket->payments->balance());
    }
}
