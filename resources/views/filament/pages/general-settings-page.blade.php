<x-filament-panels::page>
    <form wire:submit="update" class="fi-sc-form">
        {{ $this->form }}

        <div class="fi-form-actions">
            <x-filament::actions
                :actions="$this->getFormActions()"
            />
        </div>
    </form>
</x-filament-panels::page>
