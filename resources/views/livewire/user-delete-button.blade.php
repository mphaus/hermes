<span class="inline-block h-5" x-data="UserDeleteButton">
    <button type="button" class="text-primary-500 hover:text-primary-600" title="{{ __('Delete') }}" x-on:click="showDialog">
        <x-icon-trash-can class="w-5 h-5 fill-current" />
    </button>
    <dialog class="p-6 space-y-8 bg-white rounded-lg shadow-xs [&::backdrop]:bg-black/20" x-ref="dialog">
        <p>{!! __('Are you sure you want to delete user <span class="font-semibold">:full_name</span>?', ['full_name' => $user->full_name]) !!}</p>
        <form method="dialog" class="flex items-center justify-end gap-2">
            <x-button value="cancel" variant="primary" autofocus>{{ __('Cancel') }}</x-button>
            <x-button value="ok" variant="outline-primary">{{ __('OK') }}</x-button>
        </form>
    </dialog>
</span>
