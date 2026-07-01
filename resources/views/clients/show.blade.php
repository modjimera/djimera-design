<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-[#3b2418]">{{ $client->nom }}</h1>
                <p class="text-sm text-stone-600">{{ $client->telephone ?? 'Téléphone non renseigné' }} · {{ $client->whatsapp ?? 'WhatsApp non renseigné' }}</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('commandes.create', ['client_id' => $client->id]) }}" class="rounded-md border border-[#7f1d1d] px-4 py-2 text-sm font-semibold text-[#7f1d1d]">Commande</a>
                <a href="{{ route('clients.edit', $client) }}" class="rounded-md bg-[#7f1d1d] px-4 py-2 text-sm font-semibold text-white hover:bg-[#651616]">Modifier</a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto grid max-w-7xl gap-6 px-4 sm:px-6 lg:grid-cols-3 lg:px-8">
            <div class="space-y-6">
                <section class="rounded-lg border border-[#eadfcc] bg-white p-6 shadow-sm">
                    <h2 class="text-lg font-semibold text-[#3b2418]">Fiche client</h2>
                    <dl class="mt-4 space-y-3 text-sm">
                        <div><dt class="text-stone-500">Email</dt><dd>{{ $client->email ?? '-' }}</dd></div>
                        <div><dt class="text-stone-500">Adresse</dt><dd>{{ $client->adresse ?? '-' }}</dd></div>
                        <div><dt class="text-stone-500">Naissance</dt><dd>{{ $client->date_naissance?->format('d/m/Y') ?? '-' }}</dd></div>
                        <div><dt class="text-stone-500">Genre</dt><dd>{{ $client->genre ?? '-' }}</dd></div>
                        <div><dt class="text-stone-500">Profession</dt><dd>{{ $client->profession ?? '-' }}</dd></div>
                        <div><dt class="text-stone-500">Source</dt><dd>{{ $client->source ?? '-' }}</dd></div>
                        <div><dt class="text-stone-500">Solde</dt><dd>{{ number_format($client->solde, 0, ',', ' ') }} FCFA</dd></div>
                        <div><dt class="text-stone-500">Rappel</dt><dd>{{ $client->rappel_at?->format('d/m/Y') ?? '-' }}</dd></div>
                    </dl>
                </section>

                <section class="rounded-lg border border-[#eadfcc] bg-white p-6 shadow-sm">
                    <h2 class="text-lg font-semibold text-[#3b2418]">Style</h2>
                    <dl class="mt-4 space-y-3 text-sm">
                        <div><dt class="text-stone-500">Taille habit</dt><dd>{{ $client->taille_habit ?? '-' }}</dd></div>
                        <div><dt class="text-stone-500">Morphologie</dt><dd>{{ $client->morphologie ?? '-' }}</dd></div>
                        <div><dt class="text-stone-500">Préférences</dt><dd>{{ $client->preferences_style ?? '-' }}</dd></div>
                        <div><dt class="text-stone-500">Couleurs</dt><dd>{{ $client->couleurs_favorites ?? '-' }}</dd></div>
                        <div><dt class="text-stone-500">Tissus préférés</dt><dd>{{ $client->tissus_preferes ?? '-' }}</dd></div>
                        <div><dt class="text-stone-500">Tissus à éviter</dt><dd>{{ $client->allergies_tissus ?? '-' }}</dd></div>
                        <div><dt class="text-stone-500">Livraison</dt><dd>{{ $client->instructions_livraison ?? '-' }}</dd></div>
                    </dl>
                </section>
            </div>

            <div class="space-y-6 lg:col-span-2">
                <section class="rounded-lg border border-[#eadfcc] bg-white p-6 shadow-sm">
                    <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h2 class="text-lg font-semibold text-[#3b2418]">Mensurations</h2>
                            <p class="text-sm text-stone-500">
                                {{ $client->measurement?->mesure_at ? 'Prises le '.$client->measurement->mesure_at->format('d/m/Y') : 'Date de prise non renseignée' }}
                                @if ($client->measurement?->prise_par)
                                    · par {{ $client->measurement->prise_par }}
                                @endif
                            </p>
                        </div>
                    </div>

                    @php
                        $measurements = [
                            'Tour cou' => $client->measurement?->tour_cou,
                            'Poitrine' => $client->measurement?->tour_poitrine,
                            'Taille' => $client->measurement?->tour_taille,
                            'Hanches' => $client->measurement?->tour_hanches,
                            'Épaule' => $client->measurement?->epaule,
                            'Carrure dos' => $client->measurement?->carrure_dos,
                            'Buste' => $client->measurement?->longueur_buste,
                            'Robe' => $client->measurement?->longueur_robe,
                            'Jupe' => $client->measurement?->longueur_jupe,
                            'Boubou' => $client->measurement?->longueur_boubou,
                            'Pantalon' => $client->measurement?->longueur_pantalon,
                            'Entrejambe' => $client->measurement?->entrejambe,
                            'Manche' => $client->measurement?->longueur_manche,
                            'Bras' => $client->measurement?->tour_bras,
                            'Emmanchure' => $client->measurement?->tour_emmanchure,
                            'Poignet' => $client->measurement?->tour_poignet,
                            'Cuisse' => $client->measurement?->tour_cuisse,
                            'Genou' => $client->measurement?->tour_genou,
                            'Cheville' => $client->measurement?->tour_cheville,
                            'Talon' => $client->measurement?->hauteur_talon,
                        ];
                    @endphp

                    <div class="mt-5 grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
                        @foreach ($measurements as $label => $value)
                            <div class="rounded-md border border-[#eadfcc] bg-[#fbf8f3] px-3 py-2">
                                <p class="text-xs font-medium uppercase text-stone-500">{{ $label }}</p>
                                <p class="mt-1 text-lg font-semibold text-[#3b2418]">{{ filled($value) ? $value.' cm' : '-' }}</p>
                            </div>
                        @endforeach
                    </div>

                    @if ($client->measurement?->notes)
                        <div class="mt-4 rounded-md bg-amber-50 p-4 text-sm text-stone-700">
                            {{ $client->measurement->notes }}
                        </div>
                    @endif
                </section>

                <section class="rounded-lg border border-[#eadfcc] bg-white p-6 shadow-sm">
                    <div class="mb-4 flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-[#3b2418]">Historique commandes</h2>
                        <a href="{{ route('commandes.create', ['client_id' => $client->id]) }}" class="text-sm font-semibold text-[#7f1d1d]">Nouvelle commande</a>
                    </div>
                    <div class="space-y-3">
                        @forelse ($client->commandes as $commande)
                            <a href="{{ route('commandes.show', $commande) }}" class="block rounded-md border border-stone-200 px-4 py-3 hover:bg-[#fbf8f3]">
                                <span class="font-medium text-[#3b2418]">{{ $commande->numero }} - {{ $commande->type_tenue ?? 'Tenue' }}</span>
                                <span class="block text-sm text-stone-600">{{ $commande->statut }} - {{ number_format($commande->prix_convenu, 0, ',', ' ') }} FCFA</span>
                            </a>
                        @empty
                            <p class="text-sm text-stone-500">Aucune commande pour ce client.</p>
                        @endforelse
                    </div>
                </section>

                <section class="rounded-lg border border-[#eadfcc] bg-white p-6 shadow-sm">
                    <h2 class="text-lg font-semibold text-[#3b2418]">Paiements récents</h2>
                    <div class="mt-4 space-y-3">
                        @forelse ($client->paiements as $paiement)
                            <div class="rounded-md border border-stone-200 px-4 py-3 text-sm">
                                <div class="flex justify-between gap-3">
                                    <span class="font-medium text-[#3b2418]">{{ $paiement->date_paiement?->format('d/m/Y') ?? '-' }} · {{ $paiement->moyen }}</span>
                                    <span>{{ number_format($paiement->montant, 0, ',', ' ') }} FCFA</span>
                                </div>
                                <p class="text-stone-500">{{ $paiement->type }}</p>
                            </div>
                        @empty
                            <p class="text-sm text-stone-500">Aucun paiement enregistré.</p>
                        @endforelse
                    </div>
                </section>
            </div>
        </div>
    </div>
</x-app-layout>
