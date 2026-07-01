<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-semibold text-[#3b2418]">Catalogue modèles</h1>
            <a href="{{ route('modeles.create') }}" class="rounded-md bg-[#7f1d1d] px-4 py-2 text-sm font-semibold text-white hover:bg-[#651616]">Nouveau modèle</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-4 rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">{{ session('status') }}</div>
            @endif

            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @forelse ($modeles as $modele)
                    <div class="overflow-hidden rounded-lg border border-[#eadfcc] bg-white shadow-sm">
                        @if ($modele->photo_path)
                            <img src="{{ asset('storage/'.$modele->photo_path) }}" alt="{{ $modele->nom }}" class="aspect-[4/3] w-full object-cover">
                        @else
                            <div class="flex aspect-[4/3] items-center justify-center bg-[#fbf8f3] text-sm text-stone-500">
                                Image à ajouter
                            </div>
                        @endif

                        <div class="p-5">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <h2 class="font-semibold text-[#3b2418]">{{ $modele->nom }}</h2>
                                    <p class="text-sm text-stone-500">{{ $modele->categorie ?? 'Catégorie libre' }}</p>
                                </div>
                                @if ($modele->favori)
                                    <span class="rounded-full bg-[#c69c48]/20 px-2 py-1 text-xs font-semibold text-[#6f4b2f]">Favori</span>
                                @endif
                            </div>
                            <p class="mt-4 line-clamp-3 text-sm text-stone-600">{{ $modele->description ?? 'Aucune description.' }}</p>
                            <div class="mt-4 flex items-center justify-between text-sm">
                                <span>{{ number_format($modele->prix_indicatif, 0, ',', ' ') }} FCFA</span>
                                <a href="{{ route('modeles.edit', $modele) }}" class="font-semibold text-[#7f1d1d]">Modifier</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-stone-500">Aucun modèle enregistré.</p>
                @endforelse
            </div>
            <div class="mt-4">{{ $modeles->links() }}</div>
        </div>
    </div>
</x-app-layout>
