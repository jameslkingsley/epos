<?php

namespace App\Basket\Collections;

use App\Basket\Basket;
use App\Events\PaymentAdded;
use App\Basket\Models\Payment;
use App\Events\PaymentRemoved;
use Illuminate\Support\Facades\Log;
use App\Basket\Exceptions\Exception;
use App\Basket\Collections\Collection;
use Illuminate\Support\Facades\Artisan;
use App\Basket\Models\TransactionHeader;
use App\Basket\Constraints\PaymentConstraint;

class PaymentCollection extends Collection
{
    /**
     * Basket instance.
     *
     * @var App\Basket\Basket
     */
    protected $basket;

    /**
     * Constraint instance.
     *
     * @var App\Basket\Constraints\PaymentConstraint
     */
    protected $constraint;

    /**
     * Constructor method.
     *
     * @return any
     */
    public function __construct($payments, $basket = null)
    {
        $this->basket = $basket;
        $this->constraint = new PaymentConstraint;

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
        return $this->basket->update(function($basket) use($payment) {
            $payment = $basket->payments->resolve($payment, [
                'amount' => $payment->amount
            ]);

            // Validate the payment, if invalid, will exit
            if (! $this->constraint->passes($basket, $payment)) {
                $basket->exception($this->constraint->reason());
                exit;
            }

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

        event(new PaymentRemoved($payment));
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

    /**
     * Commits the payments to transaction header payments.
     *
     * @return self
     */
    public function commit(TransactionHeader $header)
    {
        $this->each(function($payment) use($header) {
            $header->payments()->create([
                'amount' => $payment->amount,
                'payment_id' => $payment->id
            ]);
        });

        return $this;
    }
}
