<?php

namespace App\Basket\Traits;

use App\Basket\Models\TransactionHeader;

trait BelongsToTransactionHeader
{
    /**
     * Gets the header of the object.
     *
     * @return App\Basket\Models\TransactionHeader
     */
    public function header()
    {
        return $this->belongsTo(TransactionHeader::class);
    }
}
