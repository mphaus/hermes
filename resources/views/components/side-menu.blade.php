<aside 
    class="fixed top-0 left-0 z-40 w-64 p-4 overflow-y-auto transition-transform -translate-x-full bg-white h-dvh xl:translate-x-0"
    x-data="SideMenu"
    x-on:hermes:toggle-side-menu.window="open = $event.detail.open"
    x-bind:class="{ 'transform-none': open }"
    x-effect="sideMenuToggleEffect(open)"
></aside>
