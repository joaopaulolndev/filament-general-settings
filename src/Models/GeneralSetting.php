<?php

namespace Joaopaulolndev\FilamentGeneralSettings\Models;

use Illuminate\Database\Eloquent\Model;

class GeneralSetting extends Model
{
    protected $guarded = [
        //
    ];

    protected $casts = [
        'seo_metadata' => 'array',
        'email_settings' => 'array',
    ];
}
