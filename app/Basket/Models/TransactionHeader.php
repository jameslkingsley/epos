<?php

namespace App\Basket\Models;

use App\Basket\Models\TransactionItem;
use Illuminate\Database\Eloquent\Model;

class TransactionHeader extends Model
{
    /**
     * Gets the items for the header.
     *
     * @return Collection App\Basket\Models\TransactionItem
     */
    public function items()
    {
        return $this->hasMany(TransactionItem::class);
    }
}
