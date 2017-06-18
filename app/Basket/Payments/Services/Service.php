<?php

namespace App\Basket\Payments\Services;

use Jenssegers\Model\Model;
use App\Basket\Models\Payment;

abstract class Service extends Model
{
    /**
     * Appended attributes.
     *
     * @var array
     */
    protected $appends = [
        'name',
        'payment'
    ];

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
     * Gets the name attribute.
     *
     * @return string
     */
    public function getNameAttribute()
    {
        $parts = explode('\\', get_class($this));

        return array_pop($parts);
    }

    /**
     * Gets the payment attribute.
     *
     * @return App\Basket\Models\Payment
     */
    public function getPaymentAttribute()
    {
        return $this->payment;
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
