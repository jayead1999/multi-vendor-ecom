<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingService
{
    function getSettings()
    {
        return Cache::rememberForever('setting', function () {
            return Setting::pluck('value', 'key')->toArray();
        });
    }

    function setSettings()
    {
       $settings= $this-> getSettings();
       config()->set('settings', $settings);
    }


    function clearCashedSettings()
    {
        Cache::forget('setting');
    }
}
