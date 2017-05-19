<?php

namespace App\Basket\Models;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    /**
     * Gets the resolved model.
     *
     * @return Model
     */
    public function model()
    {
        return $this->model_type::findOrFail($this->model_id);
    }
}
