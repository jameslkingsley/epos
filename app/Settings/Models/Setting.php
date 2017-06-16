<?php

namespace App\Settings\Models;

use Illuminate\Database\Eloquent\Model;
use App\Settings\Traits\HasUserSettings;
use App\Settings\Exceptions\NotAuthenticated;

class Setting extends Model
{
    use HasUserSettings;

    /**
     * Appended attributes.
     *
     * @var array
     */
    protected $appends = [
        'values'
    ];

    /**
     * Guarded attributes.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Serializes all settings for the cache collection.
     *
     * @return Collection
     */
    public static function serializeForCache()
    {
        return static::all();
    }

    /**
     * Gets the values attribute.
     *
     * @return any
     */
    public function getValuesAttribute($values)
    {
        return $this->forUser();
    }

    /**
     * Stores the given value for the authenticated user.
     *
     * @return App\Settings\Models\UserSetting
     */
    public function persist($value)
    {
        if (auth()->guest()) {
            $this->value = $value;
            $this->save();
            return $this;
        }

        return UserSetting::create([
            'setting_id' => $this->id,
            'user_id' => auth()->user()->id,
            'value' => (string)$value
        ]);
    }
}
