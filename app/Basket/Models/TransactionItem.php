<?php

namespace App\Basket\Models;

use Illuminate\Database\Eloquent\Model;
use App\Basket\Models\TransactionHeader;
use App\Basket\Traits\BelongsToTransactionHeader;
use App\Basket\Collections\TransactionItemCollection;

class TransactionItem extends Model
{
    use BelongsToTransactionHeader;

    /**
     * Appended attributes.
     *
     * @var array
     */
    protected $appends = [
        'model',
        'net_total',
        'vat_total',
        'gross_total'
    ];

    /**
     * Guarded fields.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Gets the model instance.
     *
     * @return any
     */
    public function getModelAttribute()
    {
        return $this->model_type::findOrFail($this->model_id);
    }

    /**
     * Gets the total net amount.
     *
     * @return App\Basket\Support\Number
     */
    public function getNetTotalAttribute()
    {
        return number($this->qty * $this->net)->normal()->display();
    }

    /**
     * Gets the total VAT amount.
     *
     * @return App\Basket\Support\Number
     */
    public function getVatTotalAttribute()
    {
        return number($this->qty * $this->vat)->normal()->display();
    }

    /**
     * Gets the total gross amount.
     *
     * @return App\Basket\Support\Number
     */
    public function getGrossTotalAttribute()
    {
        return number($this->qty * $this->gross)->normal()->display();
    }

    /**
     * Create a new Eloquent Collection instance.
     *
     * @param array $models
     * @return App\Basket\Collections\TransactionItemCollection
     */
    public function newCollection(array $models = [])
    {
        return new TransactionItemCollection($models);
    }
}
