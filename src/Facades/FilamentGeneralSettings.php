<?php

namespace Joaopaulolndev\FilamentGeneralSettings\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Joaopaulolndev\FilamentGeneralSettings\FilamentGeneralSettings
 */
class FilamentGeneralSettings extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Joaopaulolndev\FilamentGeneralSettings\FilamentGeneralSettings::class;
    }
}
