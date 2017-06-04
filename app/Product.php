<?php

namespace App;

use App\Basket\Traits\IsItem;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use IsItem;

    /**
     * The appended attributes.
     *
     * @var array
     */
    protected $appends = [
        'net', 'gross', 'vat', 'meta'
    ];

    /**
     * Gets any meta info for the model.
     * Eg. Weight, pieces per pack.
     *
     * @return array
     */
    public function getMetaAttribute()
    {
        return [
            'created_at' => $this->created_at->diffForHumans(),
            'model' => collect(explode('\\', get_class($this)))->last()
        ];
    }
}
