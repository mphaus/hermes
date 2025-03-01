<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="px-4">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex items-center shrink-0">
                    <a href="{{ route('login') }}" wire:navigate>
                        <x-application-logo class="w-auto h-9" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 lg:flex">
                    @if (usercan('access-equipment-import'))
                        <x-nav-link :href="route('jobs.index')" :active="request()->routeIs('jobs.index')" wire:navigate>
                            {{ __('Equipment Import') }}
                        </x-nav-link>
                    @endif

                    @if (usercan('access-action-stream'))
                        <x-nav-link :href="route('action-stream.index')" :active="request()->routeIs('action-stream.index')" wire:navigate>
                            {{ __('Action Stream') }}
                        </x-nav-link>    
                    @endif

                    @if (usercan('access-qet'))
                        <x-nav-link :href="route('qet.index')" :active="request()->routeIs('qet.index')" wire:navigate>
                            {{ __('QET') }}
                        </x-nav-link>    
                    @endif

                    @if (usercan('create-default-discussions') || usercan('update-default-discussions'))
                        <div class="flex items-center">
                            <x-dropdown>
                                <x-slot name="trigger">
                                    <button class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out bg-white border border-transparent rounded-md hover:text-gray-700 focus:outline-none">
                                        <div>{{ __('Discussions') }}</div>
                                        <div class="ms-1">
                                            <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>
                                </x-slot>
                                <x-slot name="content">
                                    @if (usercan('create-default-discussions'))
                                        <x-dropdown-link href="{{ route('discussions.create') }}" wire:navigate>
                                            {{ __('Create Discussions') }}
                                        </x-dropdown-link>
                                    @endif

                                    @if (usercan('update-default-discussions'))
                                        <x-dropdown-link href="{{ route('discussions.edit') }}" wire:navigate>
                                            {{ __('Edit default Discussions') }}
                                        </x-dropdown-link>
                                    @endif
                                </x-slot>
                            </x-dropdown>
                        </div>
                    @endif
                    
                    @if (usercan('crud-users'))
                        <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')" wire:navigate>
                            {{ __('Users') }}
                        </x-nav-link>    
                    @endif

                    <x-nav-link href="https://mphaustralia.sharepoint.com/:w:/r/teams/MPHAdministration/_layouts/15/Doc.aspx?sourcedoc=%7B9d7fb799-bfce-4bd7-964a-9dbceff1b470%7D&action=editnew" target="_blank">
                        {{ __('Help') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden lg:flex lg:items-center lg:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out bg-white border border-transparent rounded-md hover:text-gray-700 focus:outline-none">
                            <div>{{ Auth::user()->fullName }}</div>

                            <div class="ms-1">
                                <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link href="mailto:garion@mphaus.com" target="_blank" title="{{ __('Need help?') }}">
                            {{ __('Need help?') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="flex items-center -me-2 lg:hidden">
                <button x-on:click="open = ! open" class="inline-flex items-center justify-center p-2 text-gray-400 transition duration-150 ease-in-out rounded-md hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500">
                    <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div x-bind:class="{'block': open, 'hidden': ! open}" class="hidden lg:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @if (usercan('access-equipment-import'))
                <x-responsive-nav-link :href="route('jobs.index')" :active="request()->routeIs('jobs.index')" wire:navigate>
                    {{ __('Equipment Import') }}
                </x-responsive-nav-link>
            @endif

            @if (usercan('access-action-stream'))
                <x-responsive-nav-link :href="route('action-stream.index')" :active="request()->routeIs('action-stream.index')" wire:navigate>
                    {{ __('Action Stream') }}
                </x-responsive-nav-link>
            @endif            
            
            @if (usercan('access-qet'))
                <x-responsive-nav-link :href="route('qet.index')" :active="request()->routeIs('qet.index')" wire:navigate>
                    {{ __('QET') }}
                </x-responsive-nav-link>    
            @endif
        </div>

        @if (usercan('create-default-discussions') || usercan('update-default-discussions'))
            <div class="pt-2 pb-1">
                <div class="px-4">
                    <div class="text-sm font-medium text-gray-500">{{ __('Discussions') }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    @if (usercan('create-default-discussions'))
                        <x-responsive-nav-link href="{{ route('discussions.create') }}" wire:navigate>
                            {{ __('Create Discussions') }}
                        </x-responsive-nav-link>
                    @endif
                    
                    @if (usercan('update-default-discussions'))
                        <x-responsive-nav-link href="{{ route('discussions.edit') }}" wire:navigate>
                            {{ __('Edit default Discussions') }}
                        </x-responsive-nav-link>
                    @endif
                </div>
            </div>
        @endif
        
        <div class="pt-2 pb-3 space-y-1">
            @if (usercan('crud-users'))
                <x-responsive-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')" wire:navigate>
                    {{ __('Users') }}
                </x-responsive-nav-link>
            @endif
            
            <x-responsive-nav-link href="https://mphaustralia.sharepoint.com/:w:/r/teams/MPHAdministration/_layouts/15/Doc.aspx?sourcedoc=%7B9d7fb799-bfce-4bd7-964a-9dbceff1b470%7D&action=editnew" target="_blank">
                {{ __('Help') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="text-sm font-medium text-gray-500">{{ Auth::user()->full_name }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link href="mailto:garion@mphaus.com" target="_blank" title="{{ __('Need help?') }}">
                    {{ __('Need help?') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
