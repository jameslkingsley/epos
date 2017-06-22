<?php

namespace App\Settings\Traits;

use App\Settings\Models\UserSetting;

trait HasUserSettings
{
    /**
     * Gets settings for the authenticated user.
     *
     * @return Collection App\Settings\Models\UserSetting
     */
    public function forUser()
    {
        if (auth()->guest()) return null;

        return UserSetting::where('setting_id', $this->id)
            ->where('user_id', auth()->user()->id)
            ->first();
    }
}
