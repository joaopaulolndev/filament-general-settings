<?php

namespace Joaopaulolndev\FilamentGeneralSettings\Pages;

use Filament\Pages\Page;

class GeneralSettingsPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament-general-settings::filament.pages.general-settings-page';
}
