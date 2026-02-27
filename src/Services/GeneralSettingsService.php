<?php

namespace Joaopaulolndev\FilamentGeneralSettings\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Joaopaulolndev\FilamentGeneralSettings\Models\GeneralSetting;

class GeneralSettingsService
{
    public function __construct(
        public GeneralSetting $generalSetting
    ) {}

    public static function getModel(): Model
    {
        $modelClass = config('filament-general-settings.model', GeneralSetting::class);

        return new $modelClass;
    }

    public function get(): ?Model
    {
        return Cache::remember('general_settings', config('filament-general-settings.expiration_cache_config_time'), callback: function () {
            return static::getModel()->first();
        });
    }
}
