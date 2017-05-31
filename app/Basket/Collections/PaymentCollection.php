<?php

namespace App\Basket\Collections;

use App\Events\PaymentAdded;
use App\Basket\Models\Payment;
use App\Events\BasketException;
use Illuminate\Support\Facades\Log;
use App\Basket\Exceptions\Exception;
use App\Basket\Collections\Collection;
use Illuminate\Support\Facades\Artisan;

class PaymentCollection extends Collection
{
    /**
     * Basket instance.
     *
     * @var App\Basket\Basket
     */
    protected $basket;

    /**
     * Constructor method.
     *
     * @return any
     */
    public function __construct($payments, $basket = null)
    {
        $this->basket = $basket;

        foreach ($payments as $payment) {
            $this->push($payment);
        }
    }

    /**
     * Gets the balance of all payments.
     *
     * @return App\Basket\Support\Number
     */
    public function balance()
    {
        $total = 0;

        $this->each(function($payment) use(&$total) {
            $total += $payment->amount;
        });

        return number($total);
    }

    /**
     * Resolves the payment model while keeping dynamic properties.
     *
     * @return App\Basket\Models\Payment
     */
    public function resolve($payment, array $props = [])
    {
        $model = ($payment instanceof Payment) ? $payment : Payment::findOrFail($payment->id);

        foreach ($props as $key => $value) {
            $model->$key = $value;
        }

        return $model;
    }

    /**
     * Validates the payment to check if it can be added.
     *
     * @throws App\Events\BasketException
     * @return void
     */
    public function validate(Payment $payment)
    {
        try {
            $payment->provider->canBeAdded($this->basket);
        } catch(Exception $e) {
            event(new BasketException($e->getMessage()));
            exit;
        }
    }

    /**
     * Adds a payment to the collection.
     *
     * @return self
     */
    public function add($payment)
    {
        return $this->basket->update(function($basket) use($payment) {
            $payment = $basket->payments->resolve($payment, [
                'amount' => $payment->amount
            ]);

            // Validate the payment
            // If invalid, will exit
            $basket->payments->validate($payment);

            // Compute the amount via the provider incase it needs to be mutated
            $payment->amount = $payment->provider->amount($payment->amount);

            if ($basket->payments->has($payment)) {
                $basket->payments->update($payment, function(&$p) use($payment) {
                    $p->amount += $payment->amount;
                });
            } else {
                $basket->payments->push($payment);
            }

            // Return the updated basket, with the payment added event
            return $basket->withEvent(PaymentAdded::class, $payment);
        });
    }

    /**
     * Removes the given payment from the collection.
     *
     * @return self
     */
    public function remove(Payment $payment)
    {
        $this->items = $this->reject(function($p) use($payment) {
            return $p->isSameAs($payment);
        })->all();
    }

    /**
     * Removes all payments from the basket.
     *
     * @return self
     */
    public function empty()
    {
        $this->items = [];

        return $this;
    }

    /**
     * Updates the given payment via the closure.
     *
     * @return self
     */
    public function update(Payment $payment, callable $closure)
    {
        $this->each(function(&$p) use($payment, $closure) {
            if ($p->isSameAs($payment)) {
                $closure($p);
            }
        });

        return $this;
    }

    /**
     * Checks if the collection has the given payment.
     *
     * @return boolean
     */
    public function has($payment)
    {
        return $this->contains(function($p) use($payment) {
            return $p->isSameAs($payment);
        });
    }
}
