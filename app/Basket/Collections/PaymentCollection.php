<?php

namespace App\Basket\Collections;

use App\Basket\Models\Payment;
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
     * Adds a payment to the collection.
     *
     * @return self
     */
    public function add($payment, $amount)
    {
        $payment = ($payment instanceof Payment) ? $payment : Payment::findOrFail($payment->id);

        // Compute the amount via the handler incase it needs to be mutated
        $payment->amount = $payment->handler()->amount($amount);

        if ($this->alreadyHas($payment)) {
            // Already has item
            $this->update($payment, function(&$p) use($payment) {
                $p->amount += $payment->amount;
            });
        } else {
            $this->push($payment);
        }

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
    public function alreadyHas(Payment $payment)
    {
        return $this->contains(function($p) use($payment) {
            return $p->isSameAs($payment);
        });
    }
}
