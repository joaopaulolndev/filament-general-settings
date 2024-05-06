<?php

namespace Joaopaulolndev\FilamentGeneralSettings\Forms;

use Filament\Forms\Components\TextInput;

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
