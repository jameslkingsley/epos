<?php

namespace App\Basket\Models;

use App\Basket\Models\Payment;
use Illuminate\Database\Eloquent\Model;
use App\Basket\Models\TransactionHeader;
use App\Basket\Traits\BelongsToTransactionHeader;
use App\Basket\Collections\TransactionPaymentCollection;

class TransactionPayment extends Model
{
    use BelongsToTransactionHeader;

    /**
     * Appended attributes.
     *
     * @var array
     */
    protected $appends = [
        'amount_total',
        'title'
    ];

    /**
     * Guarded fields.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Gets the payment instance.
     *
     * @return App\Basket\Models\Payment
     */
    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    /**
     * Gets the payment title attribute.
     *
     * @return string
     */
    public function getTitleAttribute()
    {
        return $this->payment->name;
    }

    /**
     * Gets the amount total attribute.
     *
     * @return string
     */
    public function getAmountTotalAttribute()
    {
        return number($this->amount)->normal()->display();
    }

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
