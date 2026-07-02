<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Djiméra Design Manager') }}</title>

        @include('layouts.pwa')

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('build/assets/app.css') }}">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-stone-900 antialiased">
        <div class="flex min-h-screen flex-col items-center bg-[#f8f4ef] px-4 pb-[env(safe-area-inset-bottom)] pt-6 sm:justify-center sm:pt-0">
            <div>
                <a href="/">
                    <x-application-logo class="h-24 w-24 rounded-full border border-[#c69c48]/60 bg-white shadow-sm" />
                </a>
            </div>

            <div class="mt-6 w-full max-w-md overflow-hidden rounded-lg border border-[#eadfcc] bg-white px-6 py-4 shadow-md">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
