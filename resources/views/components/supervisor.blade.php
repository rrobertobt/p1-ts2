<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Simulador Trafico</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style></style>
    @endif
</head>

<body>

    @if (session('message'))
        <div class="fixed w-full bg-cyan-400 text-white p-4 text-center top-18">
            {{ session('message') }}
        </div>
    @endif
    @if (session('error'))
        <div class="fixed w-full bg-red-500 text-white p-4 text-center top-18">
            {{ session('error') }}
        </div>
    @endif
    <nav class="bg-white border-gray-200 dark:bg-gray-900 fixed top-0  w-full">
      <div class=" flex flex-wrap items-center justify-between py-4 px-8 max-w-screen-2xl mx-auto">
            <h2 class="text-xl font-semibold text-gray-900 dark:"> <x-lucide-route
                    class="text-cyan-400 size-6 mb-1 mr-2 inline-block" />
                Simulador - Supervisor</h2>
            <div class="flex items-center md:order-2 space-x-3">
                @auth
                    <span class="text-gray-600 hover:text-gray-800 dark:text-gray-300 dark:hover:text-gray-200">
                        <span class="text-gray-400 text-sm">Usuario:</span>

                        {{ Auth::user()->name }}</span>
                @endauth

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="flex text-sm bg-gray-800 rounded-full md:me-0 focus:ring-4 p-1.5 focus:ring-gray-300 dark:focus:ring-gray-600 group relative"
                        id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown"
                        data-dropdown-placement="bottom">
                        <x-lucide-user class="size-6 group-hover:opacity-0 text-white transition" />
                        <x-lucide-log-out
                            class="size-5.5
                         group-hover:opacity-100 opacity-0 text-white absolute transition" />
                    </button>
                </form>
            </div>
            <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-user">
                <ul
                    class="flex flex-col font-medium p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
                    <li>
                        <a href="{{ route('supervisor.home') }}"
                            class="hover:text-cyan-400 transition hover:ring hover:ring-gray-300 rounded-md block py-2 px-3    md:bg-transparent  "
                            aria-current="page">Inicio</a>
                    </li>
                    <li>
                        <a href="{{ route('dashboard.supervisor.reports') }}"
                            class="hover:text-cyan-400 transition hover:ring hover:ring-gray-300 rounded-md block py-2 px-3 text-gray-900 ">Reportes</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div @class([
        'pt-34' => session('message') || session('error'),
        'pt-20 px-18 max-w-screen-xl mx-auto' => true,
    ])>
        {{ $slot }}
    </div>

</body>

</html>
