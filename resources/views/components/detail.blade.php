<div>
    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase  ">{{ $label }}</h3>
    <p class=" {{$lclass}}">
        @if($label === 'Material Type')
            {{ $value === 'P' ? 'Print' : ($value === 'NP' ? 'Non-Print' : $value) }}
        @else
            {{ $slot->isEmpty() ? $value : $slot }}
        @endif
    </p>
</div>
