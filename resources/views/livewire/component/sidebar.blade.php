<div>
    {{-- SIDEBAR --}}
    <x-slot:sidebar drawer="main-drawer" collapsible class="bg-base-100 lg:bg-inherit">

        {{-- BRAND --}}
        <x-app-brand class="px-5 pt-4" />

        {{-- MENU --}}
        <x-menu activate-by-route>

            {{-- User --}}
            @if ($user = auth()->user())
                <x-menu-separator />

                <x-list-item :item="$user" value="name" sub-value="email" no-separator no-hover
                    class="-mx-2 !-my-2 rounded">
                    <x-slot:actions>
                        <x-button icon="o-power" class="btn-circle btn-ghost btn-xs" tooltip-left="logoff" no-wire-navigate
                            link="/logout" />
                    </x-slot:actions>
                </x-list-item>

                <x-menu-separator />
            @endif

            @foreach ($menu as $menuItem)
                @if (array_key_exists('subMenu', $menuItem) && is_array($menuItem['subMenu']))
                    {{-- Render parent inside menu-sub if subMenu exists --}}
                    <x-menu-sub title="{{ $menuItem['name'] }}" icon="{{ $menuItem['icon'] }}">
                        @foreach ($menuItem['subMenu'] as $subMenuItem)
                            <x-menu-item title="{{ $subMenuItem['name'] }}" icon="{{ $subMenuItem['icon'] }}"
                                link="{{ $subMenuItem['route'] }}" />
                        @endforeach
                    </x-menu-sub>
                @else
                    {{-- Render parent as a regular menu item --}}
                    <x-menu-item title="{{ $menuItem['name'] }}" icon="{{ $menuItem['icon'] }}"
                        link="{{ $menuItem['route'] }}" />
                @endif
            @endforeach

        </x-menu>
    </x-slot:sidebar>
</div>
