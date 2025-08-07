<style>:root{--color-red-500:oklch(63.7% 0.237 25.331);--color-yellow-500:oklch(79.5% 0.184 86.047);--color-green-500:oklch(72.3% 0.219 149.579);--color-green-600:oklch(62.7% 0.194 149.214);--color-blue-600:oklch(54.6% 0.245 262.881);--color-gray-200:oklch(92.8% 0.006 264.531);--color-gray-600:oklch(44.6% 0.03 256.802);--color-white:#fff;--spacing:0.25rem;--text-sm:0.875rem;--text-sm--line-height:calc(1.25 / 0.875);--text-lg:1.125rem;--text-lg--line-height:calc(1.75 / 1.125);--font-weight-semibold:600;--radius-lg:0.5rem}.mt-1{margin-top:calc(var(--spacing) * 1)}.mt-4{margin-top:calc(var(--spacing) * 4)}.mb-1{margin-bottom:calc(var(--spacing) * 1)}.mb-2{margin-bottom:calc(var(--spacing) * 2)}.mb-4{margin-bottom:calc(var(--spacing) * 4)}.flex{display:flex}.h-3{height:calc(var(--spacing) * 3)}.h-5{height:calc(var(--spacing) * 5)}.w-3{width:calc(var(--spacing) * 3)}.w-5{width:calc(var(--spacing) * 5)}.w-full{width:100%}.items-center{align-items:center}.justify-between{justify-content:space-between}.rounded-full{border-radius:calc(infinity * 1px)}.rounded-lg{border-radius:var(--radius-lg)}.rounded-t-lg{border-top-left-radius:var(--radius-lg);border-top-right-radius:var(--radius-lg)}.bg-gray-200{background-color:var(--color-gray-200)}.bg-green-500{background-color:var(--color-green-500)}.bg-red-500{background-color:var(--color-red-500)}.bg-white{background-color:var(--color-white)}.bg-yellow-500{background-color:var(--color-yellow-500)}.p-3{padding:calc(var(--spacing) * 3)}.p-4{padding:calc(var(--spacing) * 4)}.text-left{text-align:left}.text-lg{font-size:var(--text-lg);line-height:var(--tw-leading, var(--text-lg--line-height))}.text-sm{font-size:var(--text-sm);line-height:var(--tw-leading, var(--text-sm--line-height))}.font-semibold{--tw-font-weight:var(--font-weight-semibold);font-weight:var(--font-weight-semibold)}.text-blue-600{color:var(--color-blue-600)}.text-gray-600{color:var(--color-gray-600)}.text-green-600{color:var(--color-green-600)}.shadow-lg{--tw-shadow:0 10px 15px -3px var(--tw-shadow-color, rgb(0 0 0 / 0.1)),0 4px 6px -4px var(--tw-shadow-color, rgb(0 0 0 / 0.1));box-shadow:var(--tw-inset-shadow),var(--tw-inset-ring-shadow),var(--tw-ring-offset-shadow),var(--tw-ring-shadow),var(--tw-shadow)}</style>

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
                    <x-filament::icon icon="heroicon-o-globe-alt" class="h-5 w-5 text-gray-600" />
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
