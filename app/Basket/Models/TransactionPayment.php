<?php

namespace App\Basket\Models;

use Illuminate\Database\Eloquent\Model;
use App\Basket\Models\TransactionHeader;
use App\Basket\Traits\BelongsToTransactionHeader;
use App\Basket\Collections\TransactionPaymentCollection;

class TransactionPayment extends Model
{
    use BelongsToTransactionHeader;

    /**
     * Guarded fields.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Create a new Eloquent Collection instance.
     *
     * @param array $models
     * @return App\Basket\Collections\TransactionPaymentCollection
     */
    public function newCollection(array $models = [])
    {
        return new TransactionPaymentCollection($models);
    }
}
