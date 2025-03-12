@props(['technicalSupervisor'])

<x-card class="relative">
    <a
        href="{{ route('technical-supervisors.edit', ['id' => $technicalSupervisor['id']]) }}"
        class="after:absolute after:inset-0 after:z-1 after:content-['']"
        title="{{ $technicalSupervisor['name'] }}"
        wire:navigate
    >
        {{ $technicalSupervisor['name'] }}
    </a>
</x-card>
