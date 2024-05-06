<style>
    .shadow-lg {
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    .rounded-lg {
        border-radius: 0.5rem;
    }

    .p-3 {
        padding: 0.75rem;
    }

    .bg-gray-200 {
        background-color: #edf2f7;
    }

    .rounded-t-lg {
        border-top-left-radius: 0.5rem;
        border-top-right-radius: 0.5rem;
    }

    .space-x-2 > :not(template) ~ :not(template) {
        --tw-space-x-reverse: 0;
        margin-right: calc(0.5rem * calc(1 - var(--tw-space-x-reverse)));
        margin-left: calc(0.5rem * var(--tw-space-x-reverse));
    }

    .h-3 {
        height: 0.75rem;
    }

    .w-3 {
        width: 0.75rem;
    }

    .bg-red-500 {
        background-color: #ef4444;
    }

    .bg-yellow-500 {
        background-color: #f59e0b;
    }

    .bg-green-500 {
        background-color: #10b981;
    }

    .text-lg {
        font-size: 1.125rem;
        line-height: 1.75rem;
    }

    .font-semibold {
        font-weight: 600;
    }

    .mb-1 {
        margin-bottom: 0.25rem;
    }

    .text-blue-600 {
        color: #2563eb;
    }

    .hover\:underline:hover {
        text-decoration: underline;
    }

    .text-sm {
        font-size: 0.875rem;
        line-height: 1.25rem;
    }

    .text-green-600 {
        color: #059669;
    }

    .text-gray-600 {
        color: #4b5563;
    }

    .hover\:underline:hover {
        text-decoration: underline;
    }

    .text-blue-600 {
        color: #2563eb;
    }

    .hover\:underline:hover {
        text-decoration: underline;
    }

    .text-sm {
        font-size: 0.875rem;
        line-height: 1.25rem;
    }

    .text-green-600 {
        color: #059669;
    }

    .text-gray-600 {
        color: #4b5563;
    }
</style>

<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>
    <div x-data="{ state: $wire.$entangle('{{ $getStatePath() }}') }">
        <div class="text-left">
            <div class="mt-4 text-gray-600 text-sm mb-2">
                {{ __('filament-general-settings::default.seo_preview_helper_text') }}
            </div>
        </div>

        <div class="bg-white shadow-lg rounded-lg w-full">
            <div class="flex items-center justify-between p-3 bg-gray-200 rounded-t-lg">
                <div class="flex items-center space-x-2">
                    <div class="h-3 w-3 bg-red-500 rounded-full" style="margin-right: 9px;"></div>
                    <div class="h-3 w-3 bg-yellow-500 rounded-full"></div>
                    <div class="h-3 w-3 bg-green-500 rounded-full"></div>
                </div>
                <div class="flex items-center space-x-2">
                    <x-heroicon-o-globe-alt class="h-5 w-5 text-gray-600" />
                </div>
            </div>
            <div class="p-4">
                <div class="mb-4">
                    <h3 class="text-lg font-semibold mb-1">
                        <a href="#" class="text-blue-600 hover:underline">
                            @if(!empty($this->data['seo_title']))
                                {{ $this->data['seo_title'] }}
                            @else
                                SEO Title field
                            @endif
                        </a>
                    </h3>
                    <p class="text-sm text-green-600">
                        @if(!empty($this->data['seo_metadata']['og:url']))
                            {{ $this->data['seo_metadata']['og:url'] }}
                        @else
                            og:url
                        @endif
                    </p>
                    <p class="text-sm text-gray-600 mt-1">
                        @if(!empty($this->data['seo_metadata']['og:description']))
                            {{ $this->data['seo_metadata']['og:description'] }}
                        @else
                            og:description
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-dynamic-component>
