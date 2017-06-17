<?php

namespace App\Basket\Models;

use App\Basket\Models\Item;
use Illuminate\Database\Eloquent\Model;

class Barcode extends Model
{
    /**
     * Guarded attributes.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Gets the item from a barcode record.
     *
     * @return App\Basket\Models\Item
     */
    public function item()
    {
        if ($this->item_id) {
            return Item::findOrFail($this->item_id);
        }

        if ($this->resolver) {
            return (new $this->resolver)->resolve($this);
        }

        return null;
    }

    /**
     * Attempts to resolve the barcode to an item.
     *
     * @return App\Basket\Models\Item | null
     */
    public function resolve($code)
    {
        // Try find item using full barcode
        $match = static::where('code', $code)
            ->where('partial', false)
            ->first();

        if ($match) {
            return $match->item();
        } else {
            $partials = static::where('partial', true)->get();

            foreach ($partials as $partial) {
                if (str_contains($code, $partial->code) || str_contains($partial->code, $code)) {
                    return $partial->item();
                }
            }
        }

        return null;
    }
}
