<?php

namespace App;

use App\Support\HasPrices;
use App\Support\BelongsToCategory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use BelongsToCategory,
        HasPrices;
}
