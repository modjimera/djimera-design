<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-[#3b2418]">{{ $commande->numero }}</h1>
                <p class="text-sm text-stone-600">{{ $commande->client?->nom }} - {{ $commande->statut }}</p>
            </div>
            <a href="{{ route('commandes.edit', $commande) }}" class="rounded-md bg-[#7f1d1d] px-4 py-2 text-sm font-semibold text-white hover:bg-[#651616]">Modifier</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto grid max-w-7xl gap-6 px-4 sm:px-6 lg:grid-cols-3 lg:px-8">
            <section class="rounded-lg border border-[#eadfcc] bg-white p-6 shadow-sm lg:col-span-2">
                <h2 class="text-lg font-semibold text-[#3b2418]">Détail commande</h2>
                <dl class="mt-4 grid gap-4 text-sm sm:grid-cols-2">
                    <div><dt class="text-stone-500">Type</dt><dd>{{ $commande->type_tenue ?? '-' }}</dd></div>
                    <div><dt class="text-stone-500">Tissu</dt><dd>{{ $commande->tissu_utilise ?? '-' }}</dd></div>
                    <div><dt class="text-stone-500">Prix</dt><dd>{{ number_format($commande->prix_convenu, 0, ',', ' ') }} FCFA</dd></div>
                    <div><dt class="text-stone-500">Avance</dt><dd>{{ number_format($commande->avance_versee, 0, ',', ' ') }} FCFA</dd></div>
                    <div><dt class="text-stone-500">Reste</dt><dd>{{ number_format($commande->reste_a_payer, 0, ',', ' ') }} FCFA</dd></div>
                    <div><dt class="text-stone-500">Livraison</dt><dd>{{ $commande->date_livraison_prevue?->format('d/m/Y') ?? '-' }}</dd></div>
                </dl>
                @if ($commande->notes)
                    <p class="mt-5 rounded-md bg-[#fbf8f3] p-4 text-sm text-stone-700">{{ $commande->notes }}</p>
                @endif
            </section>
            <section class="rounded-lg border border-[#eadfcc] bg-white p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-[#3b2418]">Actions rapides</h2>
                <div class="mt-4 space-y-3">
                    <a href="{{ route('paiements.create', ['commande_id' => $commande->id, 'client_id' => $commande->client_id]) }}" class="block rounded-md border border-[#eadfcc] px-4 py-3 text-sm font-semibold text-[#7f1d1d]">Enregistrer un paiement</a>
                    <a href="{{ route('factures.create', ['commande_id' => $commande->id, 'client_id' => $commande->client_id]) }}" class="block rounded-md border border-[#eadfcc] px-4 py-3 text-sm font-semibold text-[#7f1d1d]">Créer une facture</a>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
