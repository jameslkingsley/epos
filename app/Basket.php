<?php

namespace App;

use App\Accountants\General;
use App\Basket\ItemCollection;
use App\Support\BelongsToUser;
use App\Accountants\Accountant;
use Illuminate\Database\Eloquent\Model;

class Basket extends Model
{
    use BelongsToUser;

    /**
     * Don't guard any fields.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Items collection.
     *
     * @var App\Basket\ItemCollection
     */
    protected $items;

    /**
     * Constructor method.
     *
     * @return any
     */
    public function __construct()
    {
        parent::__construct();

        // Initialize a new item collection
        $this->items = new ItemCollection;
    }
}
