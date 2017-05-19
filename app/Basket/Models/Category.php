<?php

namespace App\Basket\Models;

use App\Basket\Traits\HasItems;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasItems;
}
