<?php

namespace App\Support;

trait BelongsToUser
{
    /**
     * Gets the user model.
     *
     * @return App\User
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
