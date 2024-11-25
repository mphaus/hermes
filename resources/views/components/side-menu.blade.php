@use('Illuminate\Support\Js')

<aside 
    class="fixed top-0 left-0 z-40 flex flex-col w-64 overflow-y-auto transition-transform -translate-x-full bg-white h-dvh xl:translate-x-0"
    x-data="SideMenu"
    x-on:hermes:toggle-side-menu.window="open = $event.detail.open"
    x-bind:class="{ 'transform-none': open }"
    x-effect="sideMenuToggleEffect(open)"
>
    <header class="px-3 py-6">
        <a href="{{ route('login') }}" wire:navigate>
            <x-application-logo class="w-auto h-[3.313rem]" />
        </a>
    </header>
    <section class="flex-1 px-3 py-6">
        <nav>
            <ul class="space-y-2">
                @foreach ($menuItems() as $menuitem)
                    @if ($canViewItem($menuitem['permission']))
                        <li>
                            @if (!empty($menuitem['subitems']))
                                <div x-data="{ expanded: {{ Js::from($itemExpanded($menuitem['subitems'])) }} }">
                                    <button
                                        type="button"
                                        title="{{ $menuitem['text'] }}"
                                        class="flex items-center justify-between w-full p-2 font-semibold transition duration-150 ease-in-out rounded-lg text-primary-500 hover:text-primary-600 hover:bg-gray-100"
                                        x-on:click="expanded = !expanded"
                                    >
                                        <span>{{ $menuitem['text'] }}</span>
                                        <x-icon-chevron-down class="w-5 h-5" />
                                    </button>
                                    <ul class="pl-6 mt-2 space-y-2" x-show="expanded" x-collapse x-cloak>
                                        @foreach ($menuitem['subitems'] as $subitem)
                                            @if ($canViewItem($subitem['permission']))
                                                <li>
                                                    <a
                                                        href="{{ $subitem['route'] }}"
                                                        title="{{ $subitem['text'] }}"
                                                        wire:navigate
                                                        @class([
                                                            'block p-2 text-sm rounded-lg hover:bg-gray-100',
                                                            'bg-gray-100' => $subitem['active']
                                                        ])
                                                    >
                                                        {{ $subitem['text'] }}
                                                    </a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            @else
                                <a
                                    href="{{ $menuitem['route'] }}"
                                    title="{{ $menuitem['text'] }}"
                                    wire:navigate
                                    @class([
                                        'block p-2 font-semibold transition duration-150 ease-in-out rounded-lg hover:bg-gray-100',
                                        'bg-gray-100' => $menuitem['active']
                                    ])
                                >
                                    {{ $menuitem['text'] }}
                                </a>
                            @endif
                        </li>
                    @endif
                @endforeach
                <li>
                    <a 
                        href="https://mphaustralia.sharepoint.com/:w:/r/teams/MPHAdministration/_layouts/15/Doc.aspx?sourcedoc=%7B9d7fb799-bfce-4bd7-964a-9dbceff1b470%7D&action=editnew" 
                        target="_blank"
                        class="block p-2 font-semibold transition duration-150 ease-in-out rounded-lg hover:bg-gray-100"
                    >
                        {{ __('Help') }}
                    </a>
                </li>
            </ul>
        </nav>
    </section>
    <footer class="px-3 py-6" x-data="{ expanded: false }">
        <div x-show="expanded" x-collapse x-cloak>
            <ul class="pl-2 text-sm">
                <li>
                    <a 
                        href="mailto:garion@mphaus.com"
                        target="_blank"
                        title="{{ __('Need help?') }}"
                        class="block p-2"
                    >
                        {{ __('Need help?') }}
                    </a>
                </li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a 
                            href="{{ route('logout') }}" 
                            onclick="event.preventDefault(); this.closest('form').submit();"
                            class="block p-2"
                        >
                            {{ __('Log Out') }}
                        </a>
                    </form>
                </li>
            </ul>
        </div>
        <button 
            type="button" 
            class="flex items-center justify-between w-full p-2 transition duration-150 ease-in-out rounded-lg text-primary-500 hover:text-primary-600 hover:bg-gray-100" 
            title="{{ auth()->user()->full_name }}"
            x-on:click="expanded = !expanded"
        >
            <span>{{ auth()->user()->full_name }}</span>
            <x-icon-chevron-up class="w-5 h-5" />
        </button>
    </footer>
</aside>
