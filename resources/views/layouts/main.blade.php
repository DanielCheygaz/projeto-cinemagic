<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>CineMagic</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts AND CSS Fileds -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-800">

        <!-- Navigation Menu -->
        <nav class="bg-white dark:bg-gray-900 border-b border-gray-100 dark:border-gray-800">
            <!-- Navigation Menu Full Container -->
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Logo + Menu Items + Hamburger -->
                <div class="relative flex flex-col sm:flex-row px-6 sm:px-0 grow justify-between">
                    <!-- Logo -->
                    <div class="shrink-0 -ms-4">
                        <a href="{{ route('movies.index') }}">
                            <div class="h-16 w-40 bg-cover bg-[url('../img/politecnico_h.svg')] dark:bg-[url('../img/politecnico_h_white.svg')]"></div>
                        </a>
                    </div>

                    <!-- Menu Items -->
                    <div id="menu-container" class="grow flex flex-col sm:flex-row items-stretch
                    invisible h-0 sm:visible sm:h-auto">
                        <x-menus.menu-item
                            content="All Movies"
                            selectable="1"
                            href="{{ route('movies.index') }}"
                            selected="{{ Route::currentRouteName() == 'movies.index'}}"
                        />
                        <x-menus.menu-item
                            content="Movies On Show"
                            selectable="1"
                            href="{{ route('screenings.index') }}"
                            selected="{{ Route::currentRouteName() == 'screenings.index'}}"
                        />
                        @auth
                        @can('viewAny', App\Models\Theater::class)
                        <x-menus.menu-item
                            content="Theaters"
                            selectable="1"
                            href="{{ route('theaters.index') }}"
                            selected="{{ Route::currentRouteName() == 'theaters.index'}}"
                        />
                        @endcan
                        @can('viewAny', App\Models\Customer::class)
                        <x-menus.menu-item
                            content="Users"
                            selectable="1"
                            href="{{ route('users.index') }}"
                            selected="{{ Route::currentRouteName() == 'users.index'}}"
                        />
                        <x-menus.menu-item
                            content="Statistics"
                            selectable="1"
                            href="{{ route('statistics.index') }}"
                            selected="{{ Route::currentRouteName() == 'statistics.index'}}"
                        />
                        @endcan

                        @can('viewAny', App\Models\Ticket::class)

                        <x-menus.menu-item
                            content="Validation"
                            selectable="1"
                            href="{{ route('validation.index') }}"
                            selected="{{ Route::currentRouteName() == 'validation.index'}}"
                        />

                        @endcan
                        
                        @endauth

                        <div class="grow"></div>
                        <!-- Menu Item: Cart -->
                        @if (session()->has('cart'))
                            @can('use-cart')
                            <x-menus.cart
                                :href="route('cart.show')"
                                selectable="1"
                                selected="{{ Route::currentRouteName() == 'cart.show'}}"
                                :total="session('cart')->count()"/>
                            @endcan
                        @endif

                        @auth
                        <x-menus.submenu
                            selectable="0"
                            uniqueName="submenu_user"
                            >
                            <x-slot:content>
                                <div class="pe-1">
                                    <img src="{{ Auth::user()->photoFullUrl}}"  class="w-11 h-11 min-w-11 min-h-11 rounded-full">
                                </div>
                                {{-- ATENÇÃO - ALTERAR FORMULA DE CALCULO DAS LARGURAS MÁXIMAS QUANDO O MENU FOR ALTERADO --}}
                                <div class="ps-1 sm:max-w-[calc(100vw-39rem)] md:max-w-[calc(100vw-41rem)] lg:max-w-[calc(100vw-46rem)] xl:max-w-[34rem] truncate">
                                    {{ Auth::user()->name }}
                                </div>
                            </x-slot>

                            <x-menus.submenu-item
                                content="Profile"
                                selectable="0"
                                href="{{ route('profile.edit') }}"/>

                            <form id="form_to_logout_from_menu" method="POST" action="{{ route('logout') }}"
                                    class="hidden">
                                @csrf
                            </form>
                            <a class="px-3 py-4 border-b-2 border-transparent
                                        text-sm font-medium leading-5 inline-flex h-auto
                                        text-gray-500 dark:text-gray-400
                                        hover:text-gray-700 dark:hover:text-gray-300
                                        hover:bg-gray-100 dark:hover:bg-gray-800
                                        focus:outline-none
                                        focus:text-gray-700 dark:focus:text-gray-300
                                        focus:bg-gray-100 dark:focus:bg-gray-800"
                                    href="#"
                                    onclick="event.preventDefault();
                                            document.getElementById('form_to_logout_from_menu').submit();">
                                Log Out
                            </a>
                        </x-menus.submenu>
                        @else
                        <!-- Menu Item: Login -->
                        <x-menus.menu-item
                            content="Login"
                            selectable="1"
                            href="{{ route('login') }}"
                            selected="{{ Route::currentRouteName() == 'login'}}"
                            />
                        @endauth
                    </div>
                    <!-- Hamburger -->
                    <div class="absolute right-0 top-0 flex sm:hidden pt-3 pe-3 text-black dark:text-gray-50">
                        <button id="hamburger_btn">
                            <svg class="h-8 w-8" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path id="hamburger_btn_open" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                                <path class="invisible" id="hamburger_btn_close" stroke-linecap="round"
                                stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Heading -->
        <header class="bg-white dark:bg-gray-900 shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h4 class="mb-1 text-base text-gray-500 dark:text-gray-400 leading-tight">
                    CineMagic
                </h4>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    @yield('header-title')
                </h2>
            </div>
        </header>

        <main>
            <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
                @if (session('alert-msg'))
                    <x-alert type="{{ session('alert-type') ?? 'info' }}">
                        {!! session('alert-msg') !!}
                    </x-alert>
                @endif
                @if (!$errors->isEmpty())
                        <x-alert type="warning" message="Operation failed because there are validation errors!"/>
                @endif
                @yield('main')
            </div>
        </main>
    </div>
</body>

</html>
