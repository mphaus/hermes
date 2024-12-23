<x-input 
    type="text" 
    readonly
    data-next-month-max-date="{{ now('UTC')->addMonths(1)->endOfMonth()->format('Y-m-d') }}" 
    x-data="QiInputStartsAt"
    x-modelable="value"
    x-effect="checkValue(value)"
    {{ $attributes }}
/>
