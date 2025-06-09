<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-zinc-50 dark:bg-zinc-950">
    <flux:header container class="border-b bg-zinc-50 border-zinc-800/15 dark:border-white/20 dark:bg-zinc-950 py-2">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

        <a href="{{ route('home') }}" class="ms-2 me-5 flex items-center space-x-2 rtl:space-x-reverse lg:ms-0"
            wire:navigate>
            <x-app-logo />
        </a>

        <flux:spacer />

        <flux:navbar class="max-lg:hidden pr-2">
            <flux:navbar.item icon="cpu-chip" :href="route('smartbuild')" :current="request()->routeIs('smartbuild')"
                wire:navigate>
                {{ __('SmartBuild') }}
            </flux:navbar.item>
            <flux:navbar.item icon="heart" :href="route('wishlist')" :current="request()->routeIs('wishlist')"
                wire:navigate>
                {{ __('Wishlist') }}
            </flux:navbar.item>
        </flux:navbar>

        <flux:separator orientation="vertical" variant="subtle" class="my-2" />

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
            <flux:navlist.item icon="cpu-chip" href="{{ route('smartbuild') }}" target="_blank">
                {{ __('SmartBuild') }}
            </flux:navlist.item>
            <flux:navlist.item icon="heart" href="{{ route('wishlist') }}" target="_blank">
                {{ __('Wishlist') }}
            </flux:navlist.item>
        </flux:navlist>
    </flux:sidebar>

    {{ $slot }}

    <footer
        class="bg-zinc-50 dark:bg-zinc-950 text-zinc-700 dark:text-white/90 pt-8 pb-4 mt-12 col-span-full border-t-1 border-t-zinc-800/15 dark:border-t-white/20">
        <div class="container w-5/6 mx-auto px-8 py-8 pb-16">
            <div class="flex flex-row justify-between w-full">
                <div class="flex flex-col gap-6 md:flex-row justify-between w-full">
                    <div class="flex flex-col gap-3 md:gap-6 md:w-1/3">
                        <span class="text-sm md:text-base font-bold">Customer Care</span>
                        <div class="flex flex-col gap-2 md:gap-4 text-xs md:text-sm font-medium dark:text-white/80">
                            <span>KABA Store<br>Jl. Raya Mayjen Sungkono No.KM 5, Dusun 2, Blater, Kec. Kalimanah,
                                Kabupaten Purbalingga, Jawa Tengah 53371</span>
                            <span>Monday - Friday<br>8:00 AM - 8:00 PM WIB</span>
                            <span>Saturday - Sunday<br>8:00 AM - 6:00 PM WIB</span>
                            <span>hello@kaba.com</span>
                            <span>0811-2345-6789</span>
                        </div>
                    </div>

                    <nav class="flex flex-col gap-3 md:gap-6 md:mx-auto">
                        <span class="text-sm md:text-base font-bold">Quick Link</span>
                        <ul class="flex flex-col gap-2 md:gap-4 text-xs md:text-sm font-medium dark:text-white/80">
                            <li>
                                <a href="{{ route('privacy-policy') }}" class="hover:underline"
                                    wire:navigate>{{ __('Privacy Policy') }}</a>
                            </li>
                            <li>
                                <a href="{{ route('terms-of-use') }}" class="hover:underline"
                                    wire:navigate>{{ __('Terms of Use') }}</a>
                            </li>
                            <li>
                                <a href="{{ route('faq') }}" class="hover:underline" wire:navigate>{{ __('FAQ') }}</a>
                            </li>
                            <li>
                                <a href="{{ route('contact-us') }}" class="hover:underline"
                                    wire:navigate>{{ __('Contact') }}</a>
                            </li>
                        </ul>
                    </nav>

                    <nav class="flex flex-col gap-3 md:gap-6 md:mx-auto">
                        <span class="text-sm md:text-base font-bold">Account</span>
                        <ul class="flex flex-col gap-2 md:gap-4 text-xs md:text-sm font-medium dark:text-white/80">
                            <li>
                                <a href="{{ route('settings.profile') }}" class="hover:underline"
                                    wire:navigate>{{ __('My Account') }}</a>
                            </li>
                            <li>
                                <a href="{{ route('login') }}" class="hover:underline"
                                    wire:navigate>{{ __('Login') }}</a>
                                /
                                <a href="{{ route('register') }}" class="hover:underline"
                                    wire:navigate>{{ __('Register') }}</a>

                            </li>
                            <li>
                                <a href="{{ route('wishlist') }}" class="hover:underline"
                                    wire:navigate>{{ __('Wishlist') }}</a>
                            </li>
                        </ul>
                    </nav>

                    <div class="flex justify-start md:ml-auto md:justify-end w-min space-x-6">
                        <a href="#" aria-label="Twitter"
                            class="size-6 fill-white/90 hover:opacity-75 transition-opacity duration-200">
                            <svg viewBox="0 0 24 24">
                                <path
                                    d="M23.954 4.569c-.885.389-1.83.654-2.825.775 1.014-.611 1.794-1.574 2.163-2.723-.951.555-2.005.959-3.127 1.184-.896-.959-2.173-1.559-3.591-1.559-2.717 0-4.92 2.203-4.92 4.917 0 .39.045.765.127 1.124C7.691 8.094 4.066 6.13 1.64 3.161c-.427.722-.666 1.561-.666 2.475 0 1.71.87 3.213 2.188 4.096-.807-.026-1.566-.248-2.228-.616v.061c0 2.385 1.693 4.374 3.946 4.827-.413.111-.849.171-1.296.171-.314 0-.615-.03-.916-.086.631 1.953 2.445 3.377 4.604 3.417-1.68 1.319-3.809 2.105-6.102 2.105-.39 0-.779-.023-1.17-.067 2.189 1.394 4.768 2.209 7.557 2.209 9.054 0 13.999-7.496 13.999-13.986 0-.209 0-.42-.015-.63.961-.689 1.8-1.56 2.46-2.548l-.047-.02z" />
                            </svg>
                        </a>
                        <a href="#" aria-label="Facebook"
                            class="size-6 fill-white/90 hover:opacity-75 transition-opacity duration-200">
                            <svg viewBox="0 0 24 24">
                                <path
                                    d="M12 2.04C6.5 2.04 2 6.53 2 12.06c0 4.98 3.66 9.13 8.44 9.86v-6.97H7.97v-2.89h2.47V9.57c0-2.47 1.46-3.85 3.73-3.85 1.07 0 2 .08 2.27.12v2.46h-1.44c-1.21 0-1.44.57-1.44 1.4V12h2.78l-.36 2.89h-2.42v6.97C18.34 21.19 22 17.04 22 12.06c0-5.53-4.5-10.02-10-10.02z" />
                            </svg>
                        </a>
                        <a href="#" aria-label="Instagram"
                            class="size-6 fill-white/90 hover:opacity-75 transition-opacity duration-200">
                            <svg viewBox="0 0 24 24">
                                <path
                                    d="M12 2c2.717 0 3.056.01 4.122.06 1.065.05 1.79.217 2.428.465.66.254 1.217.598 1.772 1.153a4.908 4.908 0 011.153 1.772c.247.637.415 1.363.465 2.428.047 1.066.06 1.405.06 4.122s-.013 3.056-.06 4.122c-.05 1.065-.218 1.79-.465 2.428a4.883 4.883 0 01-.465 2.428 4.908 4.908 0 01-1.153 1.772 4.908 4.908 0 01-1.772 1.153c-.637.247-1.363.415-2.428.465-1.066.047-1.405.06-4.122.06s-3.056-.013-4.122-.06c-1.065-.05-1.79-.218-2.428-.465a4.89 4.89 0 01-1.772-1.153 4.904 4.904 0 01-1.153-1.772c-.248-.637-.415-1.363-.465-2.428C2.013 15.056 2 14.717 2 12s.013-3.056.06-4.122c.05-1.066.217-1.79.465-2.428a4.88 4.88 0 01.465-2.428A4.906 4.906 0 013.76 3.772a4.885 4.885 0 011.772-1.153C6.168 2.373 6.9 2.205 7.962 2.155 9.028 2.013 9.368 2 12 2zm0 1.802c-2.67 0-2.987.01-4.042.059-1.075.05-1.647.218-2.084.395a2.972 2.972 0 00-1.15 1.15 2.972 2.972 0 00-.395 2.084c-.049 1.054-.059 1.371-.059 4.041s.01 2.987.059 4.042c.05 1.075.218 1.647.395 2.084a2.972 2.972 0 001.15 1.15 2.972 2.972 0 002.084.395c1.054.049 1.371.059 4.041.059s2.987-.01 4.042-.059c1.075-.05 1.647-.218 2.084-.395a2.972 2.972 0 001.15-1.15 2.972 2.972 0 00.395-2.084c.049-1.054.059-1.371.059-4.041s-.01-2.987-.059-4.042c-.05-1.075-.218-1.647-.395-2.084a2.972 2.972 0 00-1.15-1.15 2.972 2.972 0 00-2.084-.395C14.987 3.812 14.67 3.802 12 3.802zm0 2.953a5.244 5.244 0 100 10.488 5.244 5.244 0 000-10.488zm0 8.685a3.44 3.44 0 110-6.88 3.44 3.44 0 010 6.88zm6.406-6.845a1.217 1.217 0 10-.001 2.434 1.217 1.217 0 000-2.434z" />
                            </svg>
                        </a>
                    </div>
                </div>

            </div>

        </div>
        <div class="pt-4 border-t border-zinc-200 dark:border-white/10 text-center">
            <p class="text-xs md:text-sm text-zinc-500 dark:text-white/20">
                &copy; Copyright KABA <span>{{ date("Y") }}</span>. All rights reserved.
            </p>
        </div>
    </footer>

    @fluxScripts
</body>

</html>