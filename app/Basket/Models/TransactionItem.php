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
        'model'
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
