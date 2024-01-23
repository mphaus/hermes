@props(['message'])

<div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
    <div class="overflow-hidden bg-red-100 shadow-sm sm:rounded-lg">
        <div class="p-6 text-red-500">
            {{ $message }}
        </div>
    </div>
</div>
