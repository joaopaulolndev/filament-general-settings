<?php

use Filament\Schemas\Components\Tabs\Tab;
use Joaopaulolndev\FilamentGeneralSettings\Enums\TypeFieldEnum;
use Joaopaulolndev\FilamentGeneralSettings\Forms\CustomForms;

function getTabStatePath(Tab $tab): ?string
{
    $reflection = new ReflectionClass($tab);

    // Walk up the class hierarchy to find the statePath property
    $class = $reflection;
    while ($class) {
        if ($class->hasProperty('statePath')) {
            $property = $class->getProperty('statePath');
            $property->setAccessible(true);

            return $property->getValue($tab);
        }
        $class = $class->getParentClass();
    }

    return null;
}

it('generates separate tabs with unique statePaths for multiple custom tabs', function () {
    $customTabs = [
        'more_configs' => [
            'label' => 'More Configs',
            'icon' => 'heroicon-o-plus-circle',
            'columns' => 1,
            'fields' => [
                'address' => [
                    'type' => TypeFieldEnum::Textarea->value,
                    'label' => 'Address',
                    'placeholder' => 'Address',
                    'rows' => '3',
                    'required' => true,
                ],
            ],
        ],
        'invoice' => [
            'label' => 'Invoice',
            'icon' => 'heroicon-o-document',
            'columns' => 1,
            'fields' => [
                'invoice_prefix' => [
                    'type' => TypeFieldEnum::Text->value,
                    'label' => 'Invoice Prefix',
                    'placeholder' => 'Invoice Prefix',
                    'required' => true,
                    'rules' => ['required', 'string', 'max:255'],
                ],
            ],
        ],
    ];

    $arrTabs = [];
    foreach ($customTabs as $key => $customTab) {
        $arrTabs[] = Tab::make($customTab['label'])
            ->label(__($customTab['label']))
            ->icon($customTab['icon'])
            ->schema(CustomForms::get($customTab['fields']))
            ->columns($customTab['columns'])
            ->statePath($key);
    }

    expect($arrTabs)->toHaveCount(2);
    expect(getTabStatePath($arrTabs[0]))->toBe('more_configs');
    expect(getTabStatePath($arrTabs[1]))->toBe('invoice');
    expect(getTabStatePath($arrTabs[0]))->not->toBe(getTabStatePath($arrTabs[1]));
});

it('uses config key as statePath instead of hardcoded value', function () {
    $customTabs = [
        'billing' => [
            'label' => 'Billing',
            'icon' => 'heroicon-o-credit-card',
            'columns' => 2,
            'fields' => [
                'currency' => [
                    'type' => TypeFieldEnum::Text->value,
                    'label' => 'Currency',
                    'placeholder' => 'Currency',
                    'required' => false,
                    'rules' => [],
                ],
            ],
        ],
    ];

    $arrTabs = [];
    foreach ($customTabs as $key => $customTab) {
        $arrTabs[] = Tab::make($customTab['label'])
            ->label(__($customTab['label']))
            ->icon($customTab['icon'])
            ->schema(CustomForms::get($customTab['fields']))
            ->columns($customTab['columns'])
            ->statePath($key);
    }

    expect($arrTabs)->toHaveCount(1);
    expect(getTabStatePath($arrTabs[0]))->toBe('billing');
    expect(getTabStatePath($arrTabs[0]))->not->toBe('more_configs');
});

it('generates correct form fields for each custom tab', function () {
    $fields = CustomForms::get([
        'address' => [
            'type' => TypeFieldEnum::Textarea->value,
            'label' => 'Address',
            'placeholder' => 'Address',
            'rows' => '3',
            'required' => true,
        ],
        'google_map' => [
            'type' => TypeFieldEnum::Textarea->value,
            'label' => 'Google Map',
            'placeholder' => 'Google Map',
            'rows' => '3',
            'required' => true,
        ],
    ]);

    expect($fields)->toHaveCount(2);
    expect($fields[0]->getName())->toBe('address');
    expect($fields[1]->getName())->toBe('google_map');
});
