<?php

namespace App\Support;

trait BelongsToCategory
{
    /**
     * Gets the category model.
     *
     * @return App\Category
     */
    public function category()
    {
        return $this->belongsTo('App\Category');
    }
}
