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
            $emailSettings = $generalSettings?->email_settings ?? [];

            $data = [
                'default_email_provider' => $emailSettings['default_email_provider'] ?? null,
                'smtp_host' => $emailSettings['smtp_host'] ?? null,
                'smtp_port' => $emailSettings['smtp_port'] ?? null,
                'smtp_encryption' => $emailSettings['smtp_encryption'] ?? null,
                'smtp_username' => $emailSettings['smtp_username'] ?? null,
                'smtp_password' => $emailSettings['smtp_password'] ?? null,
                'mailgun_domain' => $emailSettings['mailgun_domain'] ?? null,
                'mailgun_secret' => $emailSettings['mailgun_secret'] ?? null,
                'mailgun_endpoint' => $emailSettings['mailgun_endpoint'] ?? null,
                'postmark_token' => $emailSettings['postmark_token'] ?? null,
                'amazon_ses_key' => $emailSettings['amazon_ses_key'] ?? null,
                'amazon_ses_secret' => $emailSettings['amazon_ses_secret'] ?? null,
                'amazon_ses_region' => $emailSettings['amazon_ses_region'] ?? null,
                'email_from_address' => $generalSettings?->email_from_address,
                'email_from_name' => $generalSettings?->email_from_name,
            ];
        }

        config([
            'mail.from.address' => $data['email_from_address'] ?? null,
            'mail.from.name' => $data['email_from_name'] ?? null,
        ]);

        $provider = $data['default_email_provider'] ?? 'smtp';

        match ($provider) {
            'postmark' => config([
                'services.postmark.token' => $data['postmark_token'] ?? null,
            ]),
            'mailgun' => config([
                'services.mailgun.domain' => $data['mailgun_domain'] ?? null,
                'services.mailgun.secret' => $data['mailgun_secret'] ?? null,
                'services.mailgun.endpoint' => $data['mailgun_endpoint'] ?? null,
            ]),
            'ses' => config([
                'services.ses.key' => $data['amazon_ses_key'] ?? null,
                'services.ses.secret' => $data['amazon_ses_secret'] ?? null,
                'services.ses.region' => $data['amazon_ses_region'] ?? null,
            ]),
            default => config([
                'mail.mailers.smtp.host' => $data['smtp_host'] ?? null,
                'mail.mailers.smtp.port' => $data['smtp_port'] ?? null,
                'mail.mailers.smtp.encryption' => $data['smtp_encryption'] ?? null,
                'mail.mailers.smtp.username' => $data['smtp_username'] ?? null,
                'mail.mailers.smtp.password' => $data['smtp_password'] ?? null,
            ]),
        };

        return $data;
    }
}
