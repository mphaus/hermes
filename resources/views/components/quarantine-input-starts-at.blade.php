<x-input 
    type="text" 
    readonly
    data-current-date="{{ now()->format('Y-m-d') }}"
    data-next-month-max-date="{{ now('UTC')->addMonths(1)->endOfMonth()->format('Y-m-d') }}" 
    x-data="QuarantineInputStartsAt"
    x-modelable="value"
    x-effect="checkValue(value)"
    {{ $attributes }}
/>
