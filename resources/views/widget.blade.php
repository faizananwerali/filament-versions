@php
    $items = filament()->getCurrentContext()->getPlugin('filament-versions')->getItems();
@endphp
<x-filament-widgets::widget class="filament-versions-widget">
    <x-filament::card>
        <x-slot name="header">
            <x-filament::card.heading>
                {{ __('filament-versions::widget.title') }}
            </x-filament::card.heading>
        </x-slot>

        <dl class="flex flex-wrap items-center text-center gap-y-4">
            @foreach ($items as $item)
                <div class="w-1/3">
                    <dt class="text-2xl font-bold text-primary-500">{{ $item['version'] }}</dt>
                    <dl>{{ $item['name'] }}</dl>
                </div>
            @endforeach
        </dl>
    </x-filament::card>
</x-filament-widgets::widget>
