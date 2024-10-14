<?php

namespace Joaopaulolndev\FilamentGeneralSettings\Enums;

use Joaopaulolndev\FilamentGeneralSettings\Traits\WithOptions;

enum TypeFieldEnum: string
{
    use WithOptions;

    case Text = 'text';
    case Boolean = 'boolean';
    case Select = 'select';
    case Textarea = 'textarea';
    case Datetime = 'datetime';
    case Richtext = 'richtext';
}
