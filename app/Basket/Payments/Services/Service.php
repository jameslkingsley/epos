<?php

namespace App\Basket\Payments\Services;

use App\Basket\Models\Payment;

abstract class Service
{
    /**
     * Payment instance.
     *
     * @var App\Basket\Models\Payment
     */
    public $payment;

    /**
     * Constructor method.
     *
     * @return void
     */
    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }

    /**
     * Marks the service as completed.
     *
     * @return self
     */
    public function completed()
    {
        basket()->payments->update($this->payment, function(&$payment) {
            $payment->serviced = true;
        });

        return $this;
    }

    /**
     * Handles the payment service.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->completed();
    }
}
