<?php

namespace App\Basket\Constraints;

use App\Basket\Basket;

class PaymentConstraint extends Constraint
{
    /**
     * Checks if the payment can be added.
     *
     * @return boolean
     */
    public function adding()
    {
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
        if ($this->basket->summaries->balance->dueFromCustomer()->gt(0)) {
            return true;
        } else {
            return $this->reason('No payment is due from customer');
        }
    }
}
