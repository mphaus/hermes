@props(['alert'])

<div {{ $attributes->merge(['class' => 'space-y-1 text-sm']) }}>
    <p @class([
        'font-semibold' => true,
        'text-green-500' => $alert['type'] === 'success',
        'text-red-500' => $alert['type'] === 'danger',    
    ])>{{ $alert['title'] }}</p>
    <div>{!! $alert['message'] !!}</div>
</div>
