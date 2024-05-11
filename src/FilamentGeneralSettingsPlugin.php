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

    public Closure | int $sort = 100;

    public Closure | string $icon = '';

    public Closure | string $navigationGroup = '';

    public Closure | string $title = '';

    public Closure | string $navigationLabel = '';

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

    public function setSort(Closure | int $value = 100): static
    {
        $this->sort = $value;

        return $this;
    }

    public function getSort(): int
    {
        return $this->evaluate($this->sort);
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

    public function setIcon(Closure | string $value = ''): static
    {
        $this->icon = $value;

        return $this;
    }

    public function getIcon(): ?string
    {
        return ! empty($this->icon) ? $this->evaluate($this->icon) : null;
    }

    public function setNavigationGroup(Closure | string $value = ''): static
    {
        $this->navigationGroup = $value;

        return $this;
    }

    public function getNavigationGroup(): ?string
    {
        return ! empty($this->navigationGroup) ? $this->evaluate($this->navigationGroup) : null;
    }

    public function setTitle(Closure | string $value = ''): static
    {
        $this->title = $value;

        return $this;
    }

    public function getTitle(): ?string
    {
        return ! empty($this->title) ? $this->evaluate($this->title) : null;
    }

    public function setNavigationLabel(Closure | string $value = ''): static
    {
        $this->navigationLabel = $value;

        return $this;
    }

    public function getNavigationLabel(): ?string
    {
        return ! empty($this->navigationLabel) ? $this->evaluate($this->navigationLabel) : null;
    }
}
