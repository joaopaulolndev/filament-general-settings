# Filament General Settings

[![Latest Version on Packagist](https://img.shields.io/packagist/v/joaopaulolndev/filament-general-settings.svg?style=flat-square)](https://packagist.org/packages/joaopaulolndev/filament-general-settings)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/joaopaulolndev/filament-general-settings/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/joaopaulolndev/filament-general-settings/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/joaopaulolndev/filament-general-settings/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/joaopaulolndev/filament-general-settings/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/joaopaulolndev/filament-general-settings.svg?style=flat-square)](https://packagist.org/packages/joaopaulolndev/filament-general-settings)



Create really fast and easily general settings for your Laravel Filament project.

<div class="filament-hidden">
    
![Screenshot of Application Feature](https://raw.githubusercontent.com/joaopaulolndev/filament-general-settings/main/art/joaopaulolndev-filament-general-settings.jpg)

</div>

## Features & Screenshots

- **Application:** Manage your system general settings, such as title, description, and theme color.
- **Analytics:** Add your Google Analytics tracking code to your system.
- **SEO Meta:** Manage your SEO meta tags, such as title, description, and keywords.
- **Email:** Manage your email settings, such as SMTP server, port, and credentials.
- **Social Media Network:** Manage your social media network links, such as Facebook, Twitter, and Instagram.
- **Support**: [Laravel 11](https://laravel.com) and [Filament 3.x](https://filamentphp.com)

## Installation

You can install the package via composer:

```bash
composer require joaopaulolndev/filament-general-settings
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="filament-general-settings-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="filament-general-settings-config"
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="filament-general-settings-views"
```

Optionally, you can publish the translations using

```bash
php artisan vendor:publish --tag="filament-general-settings-translations"
```

Optionally, you can publish the assets using. 
Ex: to show images in default email providers.
```bash
php artisan vendor:publish --tag="filament-general-settings-assets"
```

![Screenshot of Default Email Providers](https://raw.githubusercontent.com/joaopaulolndev/filament-general-settings/main/art/default_email_provider_images.png)


This is the contents of the published config file:

```php
return [
    'show_application_tab' => true,
    'show_analytics_tab' => true,
    'show_seo_tab' => true,
    'show_email_tab' => true,
    'show_social_networks_tab' => true,
    'expiration_cache_config_time' => 60,
];
```

Optionally, if you would like to add custom tabs and custom fields follow the example on configuration using the keys `show_custom_tabs` and `custom_tabs`.

```php
use Joaopaulolndev\FilamentGeneralSettings\Enums\TypeFieldEnum;

return [
    'show_application_tab' => true,
    'show_analytics_tab' => true,
    'show_seo_tab' => true,
    'show_email_tab' => true,
    'show_social_networks_tab' => true,
    'expiration_cache_config_time' => 60,
    'show_custom_tabs'=> true,
    'custom_tabs' => [
        'more_configs' => [
            'label' => 'More Configs',
            'icon' => 'heroicon-o-plus-circle',
            'columns' => 1,
            'fields' => [
                'custom_field_1' => [
                    'type' => TypeFieldEnum::Text->value,
                    'label' => 'Custom Textfield 1',
                    'placeholder' => 'Custom Field 1',
                    'required' => true,
                    'rules' => 'required|string|max:255',
                ],
                'custom_field_2' => [
                    'type' => TypeFieldEnum::Select->value,
                    'label' => 'Custom Select 2',
                    'placeholder' => 'Select',
                    'required' => true,
                    'options' => [
                        'option_1' => 'Option 1',
                        'option_2' => 'Option 2',
                        'option_3' => 'Option 3',
                    ],
                ],
                'custom_field_3' => [
                    'type' => TypeFieldEnum::Textarea->value,
                    'label' => 'Custom Textarea 3',
                    'placeholder' => 'Textarea',
                    'rows' => '3',
                    'required' => true,
                ],
                'custom_field_4' => [
                    'type' => TypeFieldEnum::Datetime->value,
                    'label' => 'Custom Datetime 4',
                    'placeholder' => 'Datetime',
                    'seconds' => false,
                ],
                'custom_field_5' => [
                    'type' => TypeFieldEnum::Boolean->value,
                    'label' => 'Custom Boolean 5',
                    'placeholder' => 'Boolean'
                ],
            ]
        ],
    ]
];
```
### Enabling Logo and Favicon Feature

To enable the feature for choosing a logo and favicon within the application tab, you need the following steps:
1. Publish the migration file to add the `site_logo` and `site_favicon` fields to the general settings table (only if you have installed the package before this feature):
```bash
php artisan vendor:publish --tag="filament-general-settings-migrations"
php artisan migrate
```

2. Publish the configuration file:
```bash
php artisan vendor:publish --tag="filament-general-settings-config"
```

3. Open the published configuration file config/filament-general-settings.php and set the following key to true:
```bash
return [
    // Other configuration settings...
    'show_logo_and_favicon' => true,
];
```
## Usage
Add in AdminPanelProvider.php
```php

use Joaopaulolndev\FilamentGeneralSettings\FilamentGeneralSettingsPlugin;

...

->plugins([
    FilamentGeneralSettingsPlugin::make()
])
```
if you want to show for specific parameters to sort, icon, title, navigation group, navigation label and can access, you can use the following example:
```php
->plugins([
    FilamentGeneralSettingsPlugin::make()
        ->canAccess(fn() => auth()->user()->id === 1)
        ->setSort(3)
        ->setIcon('heroicon-o-cog')
        ->setNavigationGroup('Settings')
        ->setTitle('General Settings')
        ->setNavigationLabel('General Settings'),
    ])
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [João Paulo Leite Nascimento](https://github.com/joaopaulolndev)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
