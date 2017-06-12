<?php

namespace App\Basket\Printers;

use App\Basket\Basket;
use App\Basket\Models\TransactionHeader;

abstract class Printer
{
    /**
     * Transaction instance.
     *
     * @var App\Basket\Models\TransactionHeader
     */
    protected $transaction;

    /**
     * Constructor method.
     *
     * @return any
     */
    public function __construct()
    {
        $this->transaction = TransactionHeader::latest();
    }

    /**
     * Gets the receipt view model.
     *
     * @return array
     */
    public function getViewModel()
    {
        return [
            [
                'model' => null
            ]
        ];
    }
}
