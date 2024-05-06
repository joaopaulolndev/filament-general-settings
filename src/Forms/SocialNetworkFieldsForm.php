<?php

namespace Joaopaulolndev\FilamentGeneralSettings\Forms;

use Filament\Actions;
use Filament\Forms;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Joaopaulolndev\FilamentGeneralSettings\Enums\EmailProviderEnum;
use Joaopaulolndev\FilamentGeneralSettings\Mail\TestMail;
use Joaopaulolndev\FilamentGeneralSettings\Models\GeneralSetting;
use Joaopaulolndev\FilamentGeneralSettings\Services\MailSettingsService;

class SocialNetworkFieldsForm
{
    public static function get(): array
    {
        return [
            TextInput::make('whatsapp')
                ->label(__('WhatsApp'))
                //->prefixIcon('fab-whatsapp')
                ->placeholder('https://www.facebook.com/'),
            TextInput::make('facebook')
                ->label(__('Facebook'))
                //->prefixIcon('fab-facebook-f')
                ->placeholder('https://www.facebook.com/'),
            TextInput::make('instagram')
                ->label(__('Instagram'))
                //->prefixIcon('fab-instagram')
                ->placeholder('https://www.instagram.com/'),
            TextInput::make('x_twitter')
                ->label(__('Twitter'))
                //->prefixIcon('fab-x-twitter')
                ->placeholder('https://www.twitter.com/'),
            TextInput::make('youtube')
                ->label(__('YouTube'))
                //->prefixIcon('fab-youtube')
                ->placeholder('https://www.youtube.com/'),
            TextInput::make('linkedin')
                ->label(__('LinkedIn'))
                //->prefixIcon('fab-linkedin-in')
                ->placeholder('https://www.linkedin.com/'),
        ];
    }
}
