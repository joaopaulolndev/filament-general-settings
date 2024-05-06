<?php

namespace Joaopaulolndev\FilamentGeneralSettings;

use Closure;
use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Support\Concerns\EvaluatesClosures;
use Joaopaulolndev\FilamentGeneralSettings\Middleware\FilamentGeneralSettingsMiddleware;
use Joaopaulolndev\FilamentGeneralSettings\Pages\GeneralSettingsPage;

class FilamentGeneralSettingsPlugin implements Plugin
{
    use EvaluatesClosures;

    public Closure | bool $access = true;

    public function getId(): string
    {
        return 'filament-general-settings';
    }

    public function register(Panel $panel): void
    {
        $panel
            ->pages($this->preparePages())
            ->authMiddleware([FilamentGeneralSettingsMiddleware::class]);
    }

    protected function preparePages(): array
    {

        return [
            GeneralSettingsPage::class,
        ];
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }

    public function canAccess(Closure | bool $value = true): static
    {
        $this->access = $value;

        return $this;
    }

    public function getCanAccess(): bool
    {
        return $this->evaluate($this->access);
    }
}
