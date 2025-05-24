<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-white dark:bg-zinc-950">
    <flux:header container class="border-b border-zinc-200 bg-zinc-50 dark:border-neutral-700 dark:bg-zinc-950 py-2">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

        <a href="{{ route('home') }}" class="ms-2 me-5 flex items-center space-x-2 rtl:space-x-reverse lg:ms-0"
            wire:navigate>
            <x-app-logo />
        </a>

        <flux:spacer />

        <flux:navbar class="max-lg:hidden pr-2">
            <flux:navbar.item icon="academic-cap" :href="route('dashboard')" :current="request()->routeIs('dashboard')"
                wire:navigate>
                {{ __('SmartBuild') }}
            </flux:navbar.item>
            <flux:navbar.item icon="heart" :href="route('wishlist')" :current="request()->routeIs('wishlist')"
                wire:navigate>
                {{ __('Wishlist') }}
            </flux:navbar.item>
        </flux:navbar>

        <flux:separator orientation="vertical" class="my-2" />

        <!-- Desktop User Menu -->
        @auth
            <flux:dropdown position="top" align="end" class="ml-4!">
                <flux:profile class="cursor-pointer" :initials="auth()->user()->initials()" />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-medium">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    @can('is-admin')
                        <flux:menu.radio.group>
                            <flux:menu.item :href="route('dashboard')" icon="circle-stack" wire:navigate>{{ __('Dashboard') }}
                            </flux:menu.item>
                        </flux:menu.radio.group>
                        <flux:menu.separator />
                    @endcan


                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}
                        </flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        @else
            <a href="{{ route('login') }}"
                class="inline-block px-4 dark:text-white/90 text-[#1b1b18] dark:border-neutral-100 text-sm sm:text-base font-medium leading-normal dark:hover:text-white dark:hover:underline">
                Login
            </a>
        @endauth

    </flux:header>

    <!-- Mobile Menu -->
    <flux:sidebar stashable sticky
        class="lg:hidden border-e border-zinc-200 bg-zinc-50 dark:border-neutral-700 dark:bg-zinc-950">
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

        <a href="{{ route('home') }}" class="ms-1 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
            <x-app-logo />
        </a>

        <flux:spacer />

        <flux:navlist variant="outline">
            <flux:navlist.item icon="academic-cap" href="https://laravel.com/docs/starter-kits#livewire"
                target="_blank">
                {{ __('SmartBuild') }}
            </flux:navlist.item>
            <flux:navlist.item icon="heart" href="{{ route('wishlist') }}" target="_blank">
                {{ __('Wishlist') }}
            </flux:navlist.item>
        </flux:navlist>
    </flux:sidebar>

    {{ $slot }}

    @fluxScripts
</body>

</html>