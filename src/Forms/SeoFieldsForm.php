<?php

namespace Joaopaulolndev\FilamentGeneralSettings\Forms;

use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;

class SeoFieldsForm
{
    public static function get($data): array
    {
        return [
            ViewField::make('seo_description')
                ->hiddenLabel()
                ->view('filament-general-settings::forms.components.seo-description'),
            Split::make([
                Section::make([
                    TextInput::make('seo_title')
                        ->label(__('filament-general-settings::default.seo_title')),
                    TextInput::make('seo_keywords')
                        ->label(__('filament-general-settings::default.seo_keywords'))
                        ->helperText(__('filament-general-settings::default.seo_keywords_helper_text')),
                    KeyValue::make('seo_metadata')
                        ->label(__('filament-general-settings::default.seo_metadata')),
                ]),
                Section::make([
                    ViewField::make('seo_preview')
                        ->hiddenLabel()
                        ->view('filament-general-settings::forms.components.seo-preview', $data),
                ]),
            ]),
        ];
    }
}
