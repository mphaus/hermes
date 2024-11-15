<x-slot name="title">{{ __('Techinical Supervisors') }}</x-slot>
<x-slot name="heading">{{ __('Techinical Supervisors') }}</x-slot>
<div class="grid max-w-screen-xl gap-4 mx-auto md:grid-cols-3">
    @for ($i = 0; $i < 3; $i++)
        <x-card class="animate-pulse">
            <div class="h-6 bg-gray-200 rounded-lg"></div>
        </x-card>
    @endfor
</div>
