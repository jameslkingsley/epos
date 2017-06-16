<?php

namespace App\Settings\Models;

use Illuminate\Database\Eloquent\Model;
use App\Settings\Traits\BelongsToSetting;

class UserSetting extends Model
{
    use BelongsToSetting;

    /**
     * Guarded attributes.
     *
     * @var array
     */
    protected $guarded = [];
}
