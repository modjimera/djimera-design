<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1">
            <h1 class="text-2xl font-semibold text-[#3b2418]">Tableau de bord</h1>
            <p class="text-sm text-stone-600">Vue globale de l'atelier, des ventes et des alertes.</p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl space-y-8 px-4 sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">{{ session('status') }}</div>
            @endif

            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ([
                    ['label' => 'CA du mois', 'value' => number_format($stats['ca_mois'], 0, ',', ' ').' FCFA'],
                    ['label' => 'Commandes en cours', 'value' => $stats['commandes_en_cours']],
                    ['label' => 'Commandes livrées', 'value' => $stats['commandes_livrees']],
                    ['label' => 'Factures impayées', 'value' => $stats['factures_impayees']],
                    ['label' => 'Encaissements', 'value' => number_format($stats['encaissements'], 0, ',', ' ').' FCFA'],
                    ['label' => 'Décaissements', 'value' => number_format($stats['decaissements'], 0, ',', ' ').' FCFA'],
                    ['label' => 'Bénéfice estimé', 'value' => number_format($stats['benefice_estime'], 0, ',', ' ').' FCFA'],
                    ['label' => 'Stocks faibles', 'value' => $stats['stock_faible']],
                ] as $card)
                    <div class="rounded-lg border border-[#eadfcc] bg-white p-5 shadow-sm">
                        <p class="text-sm font-medium text-stone-500">{{ $card['label'] }}</p>
                        <p class="mt-2 text-2xl font-semibold text-[#3b2418]">{{ $card['value'] }}</p>
                    </div>
                @endforeach
            </div>

            <div class="grid gap-6 lg:grid-cols-3">
                <section class="rounded-lg border border-[#eadfcc] bg-white p-5 shadow-sm lg:col-span-2">
                    <div class="mb-4 flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-[#3b2418]">Commandes récentes</h2>
                        <a href="{{ route('commandes.create') }}" class="rounded-md bg-[#7f1d1d] px-4 py-2 text-sm font-semibold text-white hover:bg-[#651616]">Nouvelle commande</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-[#eadfcc] text-sm">
                            <thead class="text-left text-stone-500">
                                <tr>
                                    <th class="py-3 pr-4">N°</th>
                                    <th class="py-3 pr-4">Client</th>
                                    <th class="py-3 pr-4">Statut</th>
                                    <th class="py-3 pr-4">Livraison</th>
                                    <th class="py-3 text-right">Montant</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-stone-100">
                                @forelse ($commandesRecentes as $commande)
                                    <tr>
                                        <td class="py-3 pr-4"><a class="font-medium text-[#7f1d1d]" href="{{ route('commandes.show', $commande) }}">{{ $commande->numero }}</a></td>
                                        <td class="py-3 pr-4">{{ $commande->client?->nom }}</td>
                                        <td class="py-3 pr-4">{{ $commande->statut }}</td>
                                        <td class="py-3 pr-4">{{ $commande->date_livraison_prevue?->format('d/m/Y') ?? '-' }}</td>
                                        <td class="py-3 text-right">{{ number_format($commande->prix_convenu, 0, ',', ' ') }} FCFA</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="py-6 text-center text-stone-500">Aucune commande pour le moment.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>

                <div class="space-y-6">
                    <section class="rounded-lg border border-[#eadfcc] bg-white p-5 shadow-sm">
                        <h2 class="text-lg font-semibold text-[#3b2418]">Alertes livraison</h2>
                        <div class="mt-4 space-y-3">
                            @forelse ($livraisons as $commande)
                                <a href="{{ route('commandes.show', $commande) }}" class="block rounded-md border border-amber-200 bg-amber-50 px-3 py-2 text-sm">
                                    <span class="font-semibold text-[#3b2418]">{{ $commande->client?->nom }}</span>
                                    <span class="block text-stone-600">{{ $commande->date_livraison_prevue?->format('d/m/Y') }} - {{ $commande->statut }}</span>
                                </a>
                            @empty
                                <p class="text-sm text-stone-500">Aucune urgence de livraison.</p>
                            @endforelse
                        </div>
                    </section>

                    <section class="rounded-lg border border-[#eadfcc] bg-white p-5 shadow-sm">
                        <h2 class="text-lg font-semibold text-[#3b2418]">Stock faible</h2>
                        <div class="mt-4 space-y-3">
                            @forelse ($stocksFaibles as $stock)
                                <div class="rounded-md border border-red-200 bg-red-50 px-3 py-2 text-sm">
                                    <span class="font-semibold text-[#3b2418]">{{ $stock->nom }}</span>
                                    <span class="block text-stone-600">{{ $stock->quantite }} {{ $stock->unite }} restants</span>
                                </div>
                            @empty
                                <p class="text-sm text-stone-500">Aucun stock sous seuil.</p>
                            @endforelse
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
