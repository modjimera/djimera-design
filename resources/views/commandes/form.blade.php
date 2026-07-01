<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-semibold text-[#3b2418]">{{ $commande->exists ? 'Modifier la commande' : 'Nouvelle commande' }}</h1>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
            <form method="POST" action="{{ $commande->exists ? route('commandes.update', $commande) : route('commandes.store') }}" class="space-y-6 rounded-lg border border-[#eadfcc] bg-white p-6 shadow-sm">
                @csrf
                @if ($commande->exists) @method('PUT') @endif

                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    <div>
                        <label class="text-sm font-medium text-stone-700">Client</label>
                        <select name="client_id" required class="mt-1 w-full rounded-md border-stone-300">
                            <option value="">Choisir</option>
                            @foreach ($clients as $client)
                                <option value="{{ $client->id }}" @selected(old('client_id', request('client_id', $commande->client_id)) == $client->id)>{{ $client->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-stone-700">Modèle catalogue</label>
                        <select name="modele_id" class="mt-1 w-full rounded-md border-stone-300">
                            <option value="">Libre</option>
                            @foreach ($modeles as $modele)
                                <option value="{{ $modele->id }}" @selected(old('modele_id', $commande->modele_id) == $modele->id)>{{ $modele->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-stone-700">Numéro</label>
                        <input name="numero" value="{{ old('numero', $commande->numero) }}" placeholder="Auto" class="mt-1 w-full rounded-md border-stone-300">
                    </div>
                    <div>
                        <label class="text-sm font-medium text-stone-700">Modèle demandé</label>
                        <input name="modele_demande" value="{{ old('modele_demande', $commande->modele_demande) }}" class="mt-1 w-full rounded-md border-stone-300">
                    </div>
                    <div>
                        <label class="text-sm font-medium text-stone-700">Type de tenue</label>
                        <input name="type_tenue" value="{{ old('type_tenue', $commande->type_tenue) }}" placeholder="Robe, boubou, mariage..." class="mt-1 w-full rounded-md border-stone-300">
                    </div>
                    <div>
                        <label class="text-sm font-medium text-stone-700">Tissu utilisé</label>
                        <input name="tissu_utilise" value="{{ old('tissu_utilise', $commande->tissu_utilise) }}" placeholder="Bazin, wax, dentelle..." class="mt-1 w-full rounded-md border-stone-300">
                    </div>
                    <div>
                        <label class="text-sm font-medium text-stone-700">Prix convenu</label>
                        <input type="number" step="0.01" name="prix_convenu" value="{{ old('prix_convenu', $commande->prix_convenu ?? 0) }}" required class="mt-1 w-full rounded-md border-stone-300">
                    </div>
                    <div>
                        <label class="text-sm font-medium text-stone-700">Avance versée</label>
                        <input type="number" step="0.01" name="avance_versee" value="{{ old('avance_versee', $commande->avance_versee ?? 0) }}" class="mt-1 w-full rounded-md border-stone-300">
                    </div>
                    <div>
                        <label class="text-sm font-medium text-stone-700">Statut</label>
                        <select name="statut" class="mt-1 w-full rounded-md border-stone-300">
                            @foreach ($statuts as $statut)
                                <option value="{{ $statut }}" @selected(old('statut', $commande->statut) === $statut)>{{ $statut }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-stone-700">Date commande</label>
                        <input type="date" name="date_commande" value="{{ old('date_commande', $commande->date_commande?->format('Y-m-d')) }}" class="mt-1 w-full rounded-md border-stone-300">
                    </div>
                    <div>
                        <label class="text-sm font-medium text-stone-700">Livraison prévue</label>
                        <input type="date" name="date_livraison_prevue" value="{{ old('date_livraison_prevue', $commande->date_livraison_prevue?->format('Y-m-d')) }}" class="mt-1 w-full rounded-md border-stone-300">
                    </div>
                </div>
                <div>
                    <label class="text-sm font-medium text-stone-700">Notes</label>
                    <textarea name="notes" rows="3" class="mt-1 w-full rounded-md border-stone-300">{{ old('notes', $commande->notes) }}</textarea>
                </div>
                <div class="flex justify-end gap-3">
                    <a href="{{ route('commandes.index') }}" class="rounded-md border border-stone-300 px-4 py-2 text-sm font-semibold text-stone-700">Annuler</a>
                    <button class="rounded-md bg-[#7f1d1d] px-4 py-2 text-sm font-semibold text-white hover:bg-[#651616]">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
