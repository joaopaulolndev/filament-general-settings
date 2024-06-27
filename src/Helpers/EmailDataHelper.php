<?php

namespace Joaopaulolndev\FilamentGeneralSettings\Helpers;

class EmailDataHelper
{
    public static function getEmailConfigFromDatabase(array $data): array
    {
        $newValues = $data;

        $newValues['default_email_provider'] = $data['email_settings']['default_email_provider'] ?? 'smtp';
        $newValues['smtp_host'] = $data['email_settings']['smtp_host'] ?? null;
        $newValues['smtp_port'] = $data['email_settings']['smtp_port'] ?? null;
        $newValues['smtp_encryption'] = $data['email_settings']['smtp_encryption'] ?? null;
        $newValues['smtp_timeout'] = $data['email_settings']['smtp_timeout'] ?? null;
        $newValues['smtp_username'] = $data['email_settings']['smtp_username'] ?? null;
        $newValues['smtp_password'] = $data['email_settings']['smtp_password'] ?? null;
        $newValues['mailgun_domain'] = $data['email_settings']['mailgun_domain'] ?? null;
        $newValues['mailgun_secret'] = $data['email_settings']['mailgun_secret'] ?? null;
        $newValues['mailgun_endpoint'] = $data['email_settings']['mailgun_endpoint'] ?? null;
        $newValues['postmark_token'] = $data['email_settings']['postmark_token'] ?? null;
        $newValues['amazon_ses_key'] = $data['email_settings']['amazon_ses_key'] ?? null;
        $newValues['amazon_ses_secret'] = $data['email_settings']['amazon_ses_secret'] ?? null;
        $newValues['amazon_ses_region'] = $data['email_settings']['amazon_ses_region'] ?? null;

        return $newValues;
    }

    public static function setEmailConfigToDatabase($data): mixed
    {
        $data['email_settings'] = [
            'default_email_provider' => $data['default_email_provider'] ?? 'smtp',
            'smtp_host' => $data['smtp_host'] ?? null,
            'smtp_port' => $data['smtp_port'] ?? null,
            'smtp_encryption' => $data['smtp_encryption'] ?? null,
            'smtp_timeout' => $data['smtp_timeout'] ?? null,
            'smtp_username' => $data['smtp_username'] ?? null,
            'smtp_password' => $data['smtp_password'] ?? null,
            'mailgun_domain' => $data['mailgun_domain'] ?? null,
            'mailgun_secret' => $data['mailgun_secret'] ?? null,
            'mailgun_endpoint' => $data['mailgun_endpoint'] ?? null,
            'postmark_token' => $data['postmark_token'] ?? null,
            'amazon_ses_key' => $data['amazon_ses_key'] ?? null,
            'amazon_ses_secret' => $data['amazon_ses_secret'] ?? null,
            'amazon_ses_region' => $data['amazon_ses_region'] ?? null,
        ];

        return $data;
    }
}
