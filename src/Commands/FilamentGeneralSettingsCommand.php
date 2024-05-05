<?php

namespace Joaopaulolndev\FilamentGeneralSettings\Commands;

use Illuminate\Console\Command;

class FilamentGeneralSettingsCommand extends Command
{
    public $signature = 'filament-general-settings';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
