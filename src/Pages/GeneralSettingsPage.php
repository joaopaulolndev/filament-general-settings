<?php

namespace Joaopaulolndev\FilamentGeneralSettings\Pages;

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
use Joaopaulolndev\FilamentGeneralSettings\Forms\AnalyticsFieldsForm;
use Joaopaulolndev\FilamentGeneralSettings\Forms\ApplicationFieldsForm;
use Joaopaulolndev\FilamentGeneralSettings\Forms\EmailFieldsForm;
use Joaopaulolndev\FilamentGeneralSettings\Forms\SeoFieldsForm;
use Joaopaulolndev\FilamentGeneralSettings\Forms\SocialNetworkFieldsForm;
use Joaopaulolndev\FilamentGeneralSettings\Mail\TestMail;
use Joaopaulolndev\FilamentGeneralSettings\Models\GeneralSetting;
use Joaopaulolndev\FilamentGeneralSettings\Services\MailSettingsService;

class GeneralSettingsPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-adjustments-vertical';

    protected static string $view = 'filament-general-settings::filament.pages.general-settings-page';

    public function getTitle(): string
    {
        return __('filament-general-settings::default.title');
    }

    public ?array $data = [];

    public function mount(): void
    {
        $this->data = GeneralSetting::first()?->toArray();
        $this->getEmailConfigFromDatabase();
    }

    public function form(Form $form): Form
    {

        $arrTabs = [];

        if (config('filament-general-settings.show_application_tab')) {
            $arrTabs[] = Tabs\Tab::make('Application Tab')
                ->label(__('filament-general-settings::default.application'))
                ->icon('heroicon-o-tv')
                ->schema(ApplicationFieldsForm::get())
                ->columns(3);
        }

        if (config('filament-general-settings.show_analytics_tab')) {
            $arrTabs[] = Tabs\Tab::make('Analytics Tab')
                ->label(__('filament-general-settings::default.analytics'))
                ->icon('heroicon-o-globe-alt')
                ->schema(AnalyticsFieldsForm::get());
        }

        if (config('filament-general-settings.show_seo_tab')) {
            $arrTabs[] = Tabs\Tab::make('Seo Tab')
                ->label(__('filament-general-settings::default.seo'))
                ->icon('heroicon-o-window')
                ->schema(SeoFieldsForm::get($this->data))
                ->columns(1);
        }

        if (config('filament-general-settings.show_email_tab')) {
            $arrTabs[] = Tabs\Tab::make('Email Tab')
                ->label(__('filament-general-settings::default.email'))
                ->icon('heroicon-o-envelope')
                ->schema(EmailFieldsForm::get())
                ->columns(3);
        }

        if (config('filament-general-settings.show_social_networks_tab')) {
            $arrTabs[] = Tabs\Tab::make('Social Network Tab')
                ->label(__('filament-general-settings::default.social_networks'))
                ->icon('heroicon-o-heart')
                ->schema(SocialNetworkFieldsForm::get())
                ->columns(2);
        }

        return $form
            ->schema([
                Tabs::make('Tabs')
                    ->tabs($arrTabs),
            ])
            ->statePath('data');
    }

    public function getEmailConfigFromDatabase(): void
    {
        $this->data['default_email_provider'] = $this->data['email_settings']['default_email_provider'] ?? 'smtp';
        $this->data['smtp_host'] = $this->data['email_settings']['smtp_host'] ?? null;
        $this->data['smtp_port'] = $this->data['email_settings']['smtp_port'] ?? null;
        $this->data['smtp_encryption'] = $this->data['email_settings']['smtp_encryption'] ?? null;
        $this->data['smtp_timeout'] = $this->data['email_settings']['smtp_timeout'] ?? null;
        $this->data['smtp_username'] = $this->data['email_settings']['smtp_username'] ?? null;
        $this->data['smtp_password'] = $this->data['email_settings']['smtp_password'] ?? null;
        $this->data['mailgun_domain'] = $this->data['email_settings']['mailgun_domain'] ?? null;
        $this->data['mailgun_secret'] = $this->data['email_settings']['mailgun_secret'] ?? null;
        $this->data['mailgun_endpoint'] = $this->data['email_settings']['mailgun_endpoint'] ?? null;
        $this->data['postmark_token'] = $this->data['email_settings']['postmark_token'] ?? null;
        $this->data['amazon_ses_key'] = $this->data['email_settings']['amazon_ses_key'] ?? null;
        $this->data['amazon_ses_secret'] = $this->data['email_settings']['amazon_ses_secret'] ?? null;
        $this->data['amazon_ses_region'] = $this->data['email_settings']['amazon_ses_region'] ?? null;
    }

    public function setEmailConfigToDatabase($data): mixed
    {
        $data['email_settings'] = [
            'default_email_provider' => $data['default_email_provider'],
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

    protected function getFormActions(): array
    {
        return [
            Actions\Action::make('Save')
                ->label(__('filament-general-settings::default.save'))
                ->color('primary')
                ->submit('Update'),
        ];
    }

    public function update(): void
    {
        $data = $this->form->getState();
        $data = $this->setEmailConfigToDatabase($data);

        GeneralSetting::updateOrCreate([], $data);

        Cache::forget('general_settings');

        Notification::make()
            ->title(__('filament-general-settings::default.settings_saved'))
            ->success()
            ->send();

        redirect(request()?->header('Referer'));
    }

    public function sendTestMail(MailSettingsService $mailSettingsService): void
    {
        $data = $this->form->getState();
        $email = $data['mail_to'];

        $settings = $mailSettingsService->loadToConfig($data);

        try {
            Mail::mailer($settings['default_email_provider'])
                ->to($email)
                ->send(new TestMail([
                    'subject' => 'This is a test email to verify SMTP settings',
                    'body' => 'This is for testing email using smtp.',
                ]));
        } catch (\Exception $e) {
            Log::error('[EMAIL] ' . $e->getMessage());
            Notification::make()
                ->title(__('filament-general-settings::default.test_email_error'))
                ->body($e->getMessage())
                ->danger()
                ->send();

            return;
        }

        Notification::make()
            ->title(__('filament-general-settings::default.test_email_success') . $email)
            ->success()
            ->send();
    }
}
