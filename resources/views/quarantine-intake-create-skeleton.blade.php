<div>
    <x-slot name="title">{{ __('Quarantine Intake') }}</x-slot>
    <x-slot name="heading">
        <span>{{ __('Quarantine Intake') }}</span>
    </x-slot>
    <x-card class="max-w-screen-md mx-auto space-y-7 animate-pulse">
        <div class="h-6 bg-gray-200 rounded-lg"></div>
        @for ($i = 0; $i < 3; $i++)
            <div class="space-y-1">
                <div class="h-5 bg-gray-200 rounded-lg"></div>
                <div class="h-10 bg-gray-200 rounded-lg"></div>
            </div>
        @endfor
    </x-card>
</div>
