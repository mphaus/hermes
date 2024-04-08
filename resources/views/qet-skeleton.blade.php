<div class="space-y-4">
    <div class="hidden grid-cols-8 gap-2 px-6 text-sm font-semibold lg:grid animate-pulse">
        <div class="h-5 bg-gray-200 rounded-lg lg:col-span-2"></div>
        <div class="h-5 bg-gray-200 rounded-lg lg:col-span-2"></div>
        <div class="h-5 bg-gray-200 rounded-lg lg:col-span-2"></div>
        <div class="h-5 bg-gray-200 rounded-lg"></div>
        <div class="h-5 bg-gray-200 rounded-lg"></div>
    </div>
    @for ($i = 0; $i < 3; $i++)
        <x-card>
            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-8 animate-pulse lg:gap-2">
                <div class="h-5 bg-gray-200 rounded-lg lg:col-span-2"></div>
                <div class="h-5 bg-gray-200 rounded-lg lg:col-span-2"></div>
                <div class="h-5 bg-gray-200 rounded-lg md:col-span-2"></div>
                <div class="h-5 bg-gray-200 rounded-lg"></div>
                <div class="h-5 bg-gray-200 rounded-lg"></div>
            </div>
        </x-card>    
    @endfor
</div>
