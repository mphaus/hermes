@props(['data'])
@use('Illuminate\Support\Arr')

<x-card>
    <div class="grid gap-2 lg:grid-cols-[18rem_1fr_1fr_1fr_18rem] items-center">
        <div class="flex flex-col gap-1 text-sm">
            <p class="font-semibold lg:hidden">{{ __('Item name') }}</p>
            <p>{{ $data['item_name'] }}</p>
        </div>
        <div class="flex flex-col gap-1 text-sm">
            <p class="font-semibold lg:hidden">{{ __('Item ID') }}</p>
            <p>{{ $data['item_id'] }}</p>
        </div>
        <div class="flex flex-col gap-1 text-sm">
            <p class="font-semibold lg:hidden">{{ __('Quantity') }}</p>
            <p>{{ isset($data['quantity']) ? $data['quantity'] : __('Nil') }}</p>
        </div>
        <div class="flex flex-col gap-1 text-sm">
            <p class="font-semibold lg:hidden">{{ __('Action') }}</p>
            <p>{{ str()->ucfirst($data['action']) }}</p>
        </div>
        <div class="flex flex-col gap-1 text-sm">
            <p class="font-semibold lg:hidden">{{ __('Warnings') }}</p>
            <p @class([
                'text-red-500' => !empty($data['error']),
                'font-semibold' => !empty($data['error']),
            ])>{{ empty($data['error']) ? __('Nil') : Arr::join($data['error'], '.') }}</p>
        </div>
    </div>
</x-card>
