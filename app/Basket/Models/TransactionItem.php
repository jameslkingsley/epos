<?php

namespace App\Basket\Models;

use Illuminate\Database\Eloquent\Model;
use App\Basket\Models\TransactionHeader;

class TransactionItem extends Model
{
    /**
     * Gets the header of the item.
     *
     * @return App\Basket\Models\TransactionHeader
     */
    public function header()
    {
        return $this->belongsTo(TransactionHeader::class);
    }
}
