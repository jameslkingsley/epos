<?php

namespace App\Basket\Constraints;

use App\Basket\Basket;

class PaymentConstraint extends Constraint
{
    /**
     * Checks if the constraint passes.
     *
     * @return boolean
     */
    public function passes(Basket $basket, $payment)
    {
        $this->basket = $basket;
        $this->payment = $payment;

        return $this->assertAllTrue(
            $this->isPaymentDue()
        );
    }

    /**
     * Is a payment due from the customer.
     *
     * @return boolean
     */
    public function isPaymentDue()
    {
        if ($this->basket->summaries->balance->dueFromCustomer()->get() > 0) {
            return true;
        } else {
            $this->reason('No payment is due from customer');
            return false;
        }
    }
}
