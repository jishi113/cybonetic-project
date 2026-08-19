<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'LMS') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="flex min-h-screen">

        {{-- Sidebar --}}
        <aside class="w-64 bg-gray-900 text-gray-100 flex flex-col">
            <div class="px-6 py-4 text-xl font-bold border-b border-gray-700">
                {{ config('app.name', 'LMS') }}
            </div>

            <nav class="flex-1 px-4 py-6 space-y-2">
                <a href="{{ route('dashboard') }}"
                   class="block px-4 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('dashboard') ? 'bg-gray-700' : '' }}">
                    Dashboard
                </a>
                <a href="#" class="block px-4 py-2 rounded hover:bg-gray-700">
                    Leads
                </a>
                <a href="#" class="block px-4 py-2 rounded hover:bg-gray-700">
                    Companies
                </a>
                @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.test') }}" class="block px-4 py-2 rounded hover:bg-gray-700">
                    Admin
                </a>
                @endif
            </nav>

            <div class="px-4 py-4 border-t border-gray-700">
                <div class="text-sm text-gray-400 mb-2">
                    {{ auth()->user()->name }} ({{ auth()->user()->role }})
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm text-red-400 hover:text-red-300">
                        Log Out
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main content --}}
        <div class="flex-1 flex flex-col">
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <main class="flex-1 p-6">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>