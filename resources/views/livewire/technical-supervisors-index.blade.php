<x-slot name="title">{{ __('Techinical Supervisors') }}</x-slot>
<x-slot name="heading">{{ __('Techinical Supervisors') }}</x-slot>
<div class="flow">
    <header class="flex justify-end">
        <x-button
            href="#"
            variant="primary"
            wire:loading.class="disabled"
            wire:navigate
        >
            <x-icon-plus class="w-4 fill-current" />
            <span>{{ __('Create Technical Supervisor') }}</span>
        </x-button>
    </header>
    <section class="mt-8 flow">
        <div class="grid max-w-screen-xl gap-4 mx-auto md:grid-cols-2 lg:grid-cols-3">
            @foreach (['John Doe', 'Jane Doe', 'Alex Doe', 'Arturo Doe', 'Anne Doe'] as $technical_supervisor)
                <x-card class="relative">
                    <a
                        href="#"
                        class="after:absolute after:inset-0 after:z-[1] after:content-['']"
                        title="{{ $technical_supervisor }}"
                        wire:navigate
                    >
                        {{ $technical_supervisor }}
                    </a>
                </x-card>
            @endforeach
        </div>
    </section>
</div>
