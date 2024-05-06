<?php

namespace Joaopaulolndev\FilamentGeneralSettings\Models;

use Illuminate\Database\Eloquent\Model;

class GeneralSetting extends Model
{
    protected $fillable = [
        'site_name',
        'site_description',
        'theme_color',
        'support_email',
        'support_phone',
        'google_analytics_id',
        'posthog_html_snippet',
        'seo_title',
        'seo_keywords',
        'seo_metadata',
        'whatsapp',
        'facebook',
        'instagram',
        'x_twitter',
        'linkedin',
        'youtube',
        'email_settings',
        'email_from_name',
        'email_from_address',
    ];

    protected $casts = [
        'seo_metadata' => 'array',
        'email_settings' => 'array',
    ];
}
