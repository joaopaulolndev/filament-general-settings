<?php

namespace Joaopaulolndev\FilamentGeneralSettings\Enums;

use Joaopaulolndev\FilamentGeneralSettings\Traits\WithOptions;

enum EmailProviderEnum: string
{
    use WithOptions;

    case SMTP = 'SMTP';
    case MAILGUN = 'Mailgun';
    case SES = 'Amazon SES';
    case POSTMARK = 'Postmark';
}
