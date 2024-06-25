<?php

namespace Joaopaulolndev\FilamentGeneralSettings\Services;

class MailSettingsService
{
    public function __construct(
        public GeneralSettingsService $generalSettingsService
    ) {}

    public function loadToConfig($data = null): array
    {
        if ($data === null) {
            $generalSettings = $this->generalSettingsService->get();

            $data = [
                'default_email_provider' => $generalSettings?->email_settings['default_email_provider'],
                'smtp_host' => $generalSettings?->email_settings['smtp_host'],
                'smtp_port' => $generalSettings?->email_settings['smtp_port'],
                'smtp_encryption' => $generalSettings?->email_settings['smtp_encryption'],
                'smtp_username' => $generalSettings?->email_settings['smtp_username'],
                'smtp_password' => $generalSettings?->email_settings['smtp_password'],
                'email_from_address' => $generalSettings?->email_from_address,
                'email_from_name' => $generalSettings?->email_from_name,
            ];
        }

        config([
            'mail.mailers.smtp.host' => $data['smtp_host'] ?? null,
            'mail.mailers.smtp.port' => $data['smtp_port'] ?? null,
            'mail.mailers.smtp.encryption' => $data['smtp_encryption'] ?? null,
            'mail.mailers.smtp.username' => $data['smtp_username'] ?? null,
            'mail.mailers.smtp.password' => $data['smtp_password'] ?? null,
            'mail.from.address' => $data['email_from_address'] ?? null,
            'mail.from.name' => $data['email_from_name'] ?? null,
        ]);

        return $data;
    }
}
