<?php

namespace App\Basket\Collections;

use App\Basket\Models\Payment;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Database\Eloquent\Collection;

class PaymentCollection extends Collection
{
    /**
     * Constructor method.
     *
     * @return any
     */
    public function __construct($payments)
    {
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
     * Adds a payment to the collection.
     *
     * @return self
     */
    public function add($payment)
    {
        return basket()->update(function($basket) use($payment) {
            $payment = $this->resolve($payment, [
                'amount' => $payment->amount
            ]);

            // Compute the amount via the provider incase it needs to be mutated
            $payment->amount = $payment->provider->amount($payment->amount);

            if ($basket->payments->alreadyHas($payment)) {
                $basket->payments->update($payment, function(&$p) use($payment) {
                    $p->amount += $payment->amount;
                });
            } else {
                $basket->payments->push($payment);
            }

            return $basket;
        });
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
    public function alreadyHas(Payment $payment)
    {
        return $this->contains(function($p) use($payment) {
            return $p->isSameAs($payment);
        });
    }
}
