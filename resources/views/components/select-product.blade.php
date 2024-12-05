@props([
    'multiple' => false
])

@use('Illuminate\Support\Js')

<select 
    class="w-full"
    x-data="SelectProduct({ multiple: {{ Js::from($multiple) }} })"
    {{ $attributes }}
    @if ($multiple)
        multiple
    @endif
>
    @unless ($multiple)
        <option value="">{{ __('Select a Product') }}</option>
    @endunless
</select>
