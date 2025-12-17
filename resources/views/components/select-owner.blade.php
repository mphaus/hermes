@props([
    'placeholder'
])

<div 
    x-data="SelectOwner('{{ $placeholder }}')" 
    x-modelable="value"
>
    <template hidden x-if="fetching">
        <div class="h-10 bg-gray-200 rounded-lg animate-pulse"></div>
    </template>
    <template hidden x-if="hasFetched && members">
        <select
            {{ $attributes->merge(['class' => 'w-full']) }}
            x-ref="ownerSelectElement"
            x-modelable="value"
            x-effect="checkValue(value)"
        >
            <option value="">{{ $placeholder }}</option>
            <template hidden x-for="member in members" x-bind:key="member.id">
                <option x-bind:value="member.id" x-text="member.name"></option>
            </template>
        </select>
    </template>
    <template hidden x-if="errorMessage">
        <div class="p-4 bg-red-100 text-red-500 font-semibold rounded-lg">
            <p>
                {{ __('An unexpected error occurred while fetching Users. Please refresh the page and try again.') }}
                <span x-text="errorMessage"></span>
            </p>
        </div>
    </template>
</div>
