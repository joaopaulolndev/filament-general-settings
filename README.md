# Filament General Settings

[![Latest Version on Packagist](https://img.shields.io/packagist/v/joaopaulolndev/filament-general-settings.svg?style=flat-square)](https://packagist.org/packages/joaopaulolndev/filament-general-settings)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/joaopaulolndev/filament-general-settings/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/joaopaulolndev/filament-general-settings/actions?query=workflow%3Arun-tests+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/joaopaulolndev/filament-general-settings.svg?style=flat-square)](https://packagist.org/packages/joaopaulolndev/filament-general-settings)



Create really fast and easily general settings for your Laravel Filament project.

## Features & Screenshots
Application Feature
![Screenshot of Application Feature](./art/general_settings_1.png)

Analytics Feature
![Screenshot of Application Feature](./art/general_settings_2.png)

SEO Feature
![Screenshot of Application Feature](./art/general_settings_3.png)

Email Feature
![Screenshot of Application Feature](./art/general_settings_4.png)

Social Network Feature
![Screenshot of Application Feature](./art/general_settings_5.png)

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

## Usage
Add in AdminPanelProvider.php
```php
->plugins([
    FilamentGeneralSettingsPlugin::make()
])
```
if you want to show for specific user, you can use the method ->canAccess(fn($user) => $user->isAdmin())
```php
->plugins([
    FilamentGeneralSettingsPlugin::make()
        ->canAccess(fn() => auth()->user()->id === 1),
    ])
```

```php

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
