@php
    $links = [
        ['route' => 'dashboard', 'label' => 'Tableau'],
        ['route' => 'clients.index', 'label' => 'Clients'],
        ['route' => 'commandes.index', 'label' => 'Commandes'],
        ['route' => 'modeles.index', 'label' => 'Modèles'],
        ['route' => 'factures.index', 'label' => 'Factures'],
        ['route' => 'paiements.index', 'label' => 'Encaissements'],
        ['route' => 'depenses.index', 'label' => 'Décaissements'],
        ['route' => 'stocks.index', 'label' => 'Stock'],
        ['route' => 'staff.index', 'label' => 'Atelier'],
        ['route' => 'users.index', 'label' => 'Utilisateurs'],
    ];
@endphp

<nav class="border-b border-[#6f4b2f] bg-[#3b2418] text-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 justify-between">
            <div class="flex min-w-0">
                <div class="flex shrink-0 items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                        <span class="flex h-12 w-12 items-center justify-center overflow-hidden rounded-full border border-[#c69c48]/70 bg-[#f8f4ef] shadow-sm">
                            <img src="{{ asset('images/djimera-logo.png') }}" alt="Djiméra Design" class="h-full w-full object-cover">
                        </span>
                        <span class="hidden lg:block">
                            <span class="block text-sm font-semibold leading-tight">Djiméra Design</span>
                            <span class="block text-xs text-[#eadfcc]">Chic & Glam Suite</span>
                        </span>
                    </a>
                </div>

                <div class="hidden gap-1 sm:ms-8 2xl:flex">
                    @foreach ($links as $link)
                        <a href="{{ route($link['route']) }}" class="inline-flex items-center border-b-2 px-2 pt-1 text-sm font-medium transition {{ request()->routeIs(str($link['route'])->before('.')->toString().'*') ? 'border-[#c69c48] text-white' : 'border-transparent text-[#eadfcc] hover:border-[#c69c48]/60 hover:text-white' }}">
                            {{ $link['label'] }}
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center rounded-md border border-transparent bg-[#4a2c1d] px-3 py-2 text-sm font-medium leading-4 text-[#eadfcc] transition hover:text-white focus:outline-none">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            Profil
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                Déconnexion
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center 2xl:hidden">
                <button type="button" data-menu-toggle aria-controls="mobile-menu" aria-expanded="false" class="inline-flex items-center justify-center rounded-md p-2 text-[#eadfcc] transition hover:bg-[#4a2c1d] hover:text-white focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path data-menu-open-icon class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path data-menu-close-icon class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div id="mobile-menu" class="hidden 2xl:hidden">
        <div class="space-y-1 pb-3 pt-2">
            @foreach ($links as $link)
                <a href="{{ route($link['route']) }}" class="block border-l-4 py-2 pe-4 ps-3 text-base font-medium {{ request()->routeIs(str($link['route'])->before('.')->toString().'*') ? 'border-[#c69c48] bg-[#4a2c1d] text-white' : 'border-transparent text-[#eadfcc] hover:border-[#c69c48]/60 hover:bg-[#4a2c1d] hover:text-white' }}">
                    {{ $link['label'] }}
                </a>
            @endforeach
        </div>

        <div class="border-t border-[#6f4b2f] pb-1 pt-4 sm:hidden">
            <div class="px-4">
                <div class="text-base font-medium text-white">{{ Auth::user()->name }}</div>
                <div class="text-sm font-medium text-[#eadfcc]">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    Profil
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                        Déconnexion
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
