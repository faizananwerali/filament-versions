@php
    $items = filament()->getCurrentContext()->getPlugin('filament-versions')->getItems();
@endphp
<div class="filament-versions-nav-component py-3 px-6 mt-auto -mb-6 text-xs border-t dark:border-gray-700">
    <ul class="flex flex-wrap items-center gap-x-4 gap-y-2">
        @foreach ($items as $item)
            <li class="flex-shrink-0">{{ $item['name'] }} {{ $item['version'] }}</li>
        @endforeach
    </ul>
</div>
