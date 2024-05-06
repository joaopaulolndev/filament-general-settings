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
        return $form
            ->schema([
                Tabs::make('Tabs')
                    ->tabs([
                        Tabs\Tab::make('Application Tab')
                            ->label(__('filament-general-settings::default.application'))
                            ->icon('heroicon-o-tv')
                            ->schema($this->getApplicationFields())
                            ->columns(3),
                        Tabs\Tab::make('Analytics Tab')
                            ->label(__('filament-general-settings::default.analytics'))
                            ->icon('heroicon-o-globe-alt')
                            ->schema($this->getAnalyticsFields()),
                        Tabs\Tab::make('Seo Tab')
                            ->label(__('filament-general-settings::default.seo'))
                            ->icon('heroicon-o-window')
                            ->schema($this->getSeoFields())
                            ->columns(1),
                        Tabs\Tab::make('Email Tab')
                            ->label(__('filament-general-settings::default.email'))
                            ->icon('heroicon-o-envelope')
                            ->schema($this->getEmailFields())
                            ->columns(3),
                        Tabs\Tab::make('Social Network Tab')
                            ->label(__('filament-general-settings::default.social_networks'))
                            ->icon('heroicon-o-heart')
                            ->schema($this->getSocialNetworkFields())
                            ->columns(2),
                    ]),
            ])
            ->statePath('data');
    }

    private function getApplicationFields(): array
    {
        return [
            TextInput::make('site_name')
                ->label(__('filament-general-settings::default.site_name'))
                ->autofocus()
                ->required()
                ->columnSpanFull(),
            Textarea::make('site_description')
                ->label(__('filament-general-settings::default.site_description'))
                ->columnSpanFull(),
            TextInput::make('support_email')
                ->label(__('filament-general-settings::default.support_email'))
                ->prefixIcon('heroicon-o-envelope'),
            TextInput::make('support_phone')
                ->prefixIcon('heroicon-o-phone')
                ->label(__('filament-general-settings::default.support_phone')),
            ColorPicker::make('theme_color')
                ->label(__('filament-general-settings::default.theme_color'))
                ->prefixIcon('heroicon-o-swatch')
                ->formatStateUsing(fn (?string $state): string => $state ?? config('filament.theme.colors.primary'))
                ->helperText(__('filament-general-settings::default.theme_color_helper_text')),
        ];
    }

    private function getEmailFields(): array
    {
        return [
            Forms\Components\Grid::make()
                ->schema([
                    Section::make([
                        Select::make('default_email_provider')
                            ->label(__('filament-general-settings::default.default_email_provider'))
                            ->native(false)
                            ->allowHtml()
                            ->preload()
                            ->options(function () {
                                $options = [];
                                foreach (EmailProviderEnum::options() as $key => $value) {
                                    //@todo: need to show provider logo
                                    $options[strtolower($value)] = $key;
                                }

                                return $options;
                            })
                            ->helperText(__('filament-general-settings::default.default_email_provider_helper_text'))
                            ->live()
                            ->columnSpanFull(),
                        Forms\Components\Group::make()
                            ->schema([
                                TextInput::make('smtp_host')
                                    ->label(__('filament-general-settings::default.host')),
                                TextInput::make('smtp_port')
                                    ->label(__('filament-general-settings::default.port')),
                                Select::make('smtp_encryption')
                                    ->label(__('filament-general-settings::default.encryption'))
                                    ->options([
                                        'ssl' => 'SSL',
                                        'tls' => 'TLS',
                                    ]),
                                TextInput::make('smtp_timeout')
                                    ->label(__('filament-general-settings::default.timeout')),
                                TextInput::make('smtp_username')
                                    ->label(__('filament-general-settings::default.username')),
                                TextInput::make('smtp_password')
                                    ->label(__('filament-general-settings::default.password')),
                            ])
                            ->columns(2)
                            ->visible(fn ($state) => $state['default_email_provider'] === 'smtp'),
                        Forms\Components\Group::make()
                            ->schema([
                                TextInput::make('mailgun_domain')
                                    ->label(__('filament-general-settings::default.mailgun_domain')),
                                TextInput::make('mailgun_secret')
                                    ->label(__('filament-general-settings::default.mailgun_secret')),
                                TextInput::make('mailgun_endpoint')
                                    ->label(__('filament-general-settings::default.mailgun_endpoint')),
                            ])
                            ->columns(1)
                            ->visible(fn ($state) => $state['default_email_provider'] === 'mailgun'),
                        Forms\Components\Group::make()
                            ->schema([
                                TextInput::make('postmark_token')
                                    ->label(__('filament-general-settings::default.postmark_token')),
                            ])
                            ->columns(1)
                            ->visible(fn ($state) => $state['default_email_provider'] === 'postmark'),
                        Forms\Components\Group::make()
                            ->schema([
                                TextInput::make('amazon_ses_key')
                                    ->label(__('filament-general-settings::default.amazon_ses_key')),
                                TextInput::make('amazon_ses_secret')
                                    ->label(__('filament-general-settings::default.amazon_ses_secret')),
                                TextInput::make('amazon_ses_region')
                                    ->label(__('filament-general-settings::default.amazon_ses_region'))
                                    ->default('us-east-1'),
                            ])
                            ->columns(1)
                            ->visible(fn ($state) => $state['default_email_provider'] === 'ses'),
                    ]),
                ])
                ->columnSpan(['lg' => 2]),
            Forms\Components\Grid::make()
                ->schema([
                    Section::make([
                        TextInput::make('email_from_name')
                            ->label(__('filament-general-settings::default.email_from_name'))
                            ->helperText(__('filament-general-settings::default.email_from_name_helper_text')),
                        TextInput::make('email_from_address')
                            ->label(__('filament-general-settings::default.email_from_address'))
                            ->helperText(__('filament-general-settings::default.email_from_address_helper_text'))
                            ->email(),
                    ]),
                    Section::make()
                        ->schema([
                            TextInput::make('mail_to')
                                ->label(fn () => __('filament-general-settings::default.mail_to'))
                                ->hiddenLabel()
                                ->placeholder(fn () => __('filament-general-settings::default.mail_to'))
                                ->reactive(),
                            Forms\Components\Actions::make([
                                Forms\Components\Actions\Action::make('Send Test Mail')
                                    ->label(fn () => __('filament-general-settings::default.send_test_email'))
                                    ->disabled(fn ($state) => empty($state['mail_to']))
                                    ->action('sendTestMail')
                                    ->color('warning')
                                    ->icon('heroicon-o-paper-airplane'),
                            ])->fullWidth(),
                        ]),
                ])
                ->columnSpan(['lg' => 1]),
        ];
    }

    private function getAnalyticsFields(): array
    {
        return [
            TextInput::make('google_analytics_id')
                ->label(__('filament-general-settings::default.google_analytics_id'))
                ->placeholder('UA-123456789-1'),
            Textarea::make('posthog_html_snippet')
                ->label(__('filament-general-settings::default.posthog_html_snippet'))
                ->placeholder('<script src=\'https://app.posthog.com/123456789.js\'></script>'),
        ];
    }

    private function getSeoFields(): array
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
                        ->view('filament-general-settings::forms.components.seo-preview', $this->data),
                ]),
            ]),
        ];
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

    private function getSocialNetworkFields(): array
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
