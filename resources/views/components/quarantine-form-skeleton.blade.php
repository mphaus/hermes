 <div class="space-y-4">
    <div class="animate-pulse">
        <div class="h-6 bg-gray-200 rounded-lg"></div>
    </div>
    <div class="space-y-7">
        @for ($i = 0; $i < 3; $i++)
            <x-card class="animate-pulse">
                <div class="space-y-1">
                    <div class="h-5 bg-gray-200 rounded-lg"></div>
                    <div class="h-10 bg-gray-200 rounded-lg"></div>
                </div>
            </x-card>
        @endfor
    </div>
 </div>
