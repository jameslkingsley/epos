<?php

namespace App\Settings\Traits;

use App\Settings\Models\Setting;

trait BelongsToSetting
{
    /**
     * Gets the setting header model.
     *
     * @return App\Settings\Models\Setting
     */
    public function setting()
    {
        return $this->belongsTo(Setting::class);
    }
}
