<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-semibold text-[#3b2418]">{{ $client->exists ? 'Modifier le client' : 'Nouveau client' }}</h1>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <form method="POST" action="{{ $client->exists ? route('clients.update', $client) : route('clients.store') }}" class="space-y-6">
                @csrf
                @if ($client->exists)
                    @method('PUT')
                @endif

                <section class="rounded-lg border border-[#eadfcc] bg-white p-6 shadow-sm">
                    <h2 class="text-lg font-semibold text-[#3b2418]">Identité & contact</h2>
                    <div class="mt-4 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        <div>
                            <label class="text-sm font-medium text-stone-700">Nom complet</label>
                            <input name="nom" value="{{ old('nom', $client->nom) }}" required class="mt-1 w-full rounded-md border-stone-300">
                            @error('nom') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="text-sm font-medium text-stone-700">Téléphone</label>
                            <input name="telephone" value="{{ old('telephone', $client->telephone) }}" class="mt-1 w-full rounded-md border-stone-300">
                        </div>
                        <div>
                            <label class="text-sm font-medium text-stone-700">WhatsApp</label>
                            <input name="whatsapp" value="{{ old('whatsapp', $client->whatsapp) }}" class="mt-1 w-full rounded-md border-stone-300">
                        </div>
                        <div>
                            <label class="text-sm font-medium text-stone-700">Email</label>
                            <input type="email" name="email" value="{{ old('email', $client->email) }}" class="mt-1 w-full rounded-md border-stone-300">
                        </div>
                        <div>
                            <label class="text-sm font-medium text-stone-700">Date de naissance</label>
                            <input type="date" name="date_naissance" value="{{ old('date_naissance', $client->date_naissance?->format('Y-m-d')) }}" class="mt-1 w-full rounded-md border-stone-300">
                        </div>
                        <div>
                            <label class="text-sm font-medium text-stone-700">Genre</label>
                            <select name="genre" class="mt-1 w-full rounded-md border-stone-300">
                                <option value="">Non renseigné</option>
                                @foreach (['Femme', 'Homme', 'Enfant'] as $genre)
                                    <option value="{{ $genre }}" @selected(old('genre', $client->genre) === $genre)>{{ $genre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="lg:col-span-2">
                            <label class="text-sm font-medium text-stone-700">Adresse</label>
                            <input name="adresse" value="{{ old('adresse', $client->adresse) }}" class="mt-1 w-full rounded-md border-stone-300">
                        </div>
                        <div>
                            <label class="text-sm font-medium text-stone-700">Profession</label>
                            <input name="profession" value="{{ old('profession', $client->profession) }}" class="mt-1 w-full rounded-md border-stone-300">
                        </div>
                    </div>
                </section>

                <section class="rounded-lg border border-[#eadfcc] bg-white p-6 shadow-sm">
                    <h2 class="text-lg font-semibold text-[#3b2418]">Style, préférences & suivi</h2>
                    <div class="mt-4 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                        <div>
                            <label class="text-sm font-medium text-stone-700">Source client</label>
                            <input name="source" value="{{ old('source', $client->source) }}" placeholder="Instagram, recommandation..." class="mt-1 w-full rounded-md border-stone-300">
                        </div>
                        <div>
                            <label class="text-sm font-medium text-stone-700">Taille habit</label>
                            <input name="taille_habit" value="{{ old('taille_habit', $client->taille_habit) }}" placeholder="S, M, L, 42..." class="mt-1 w-full rounded-md border-stone-300">
                        </div>
                        <div>
                            <label class="text-sm font-medium text-stone-700">Morphologie</label>
                            <input name="morphologie" value="{{ old('morphologie', $client->morphologie) }}" placeholder="A, H, X, V..." class="mt-1 w-full rounded-md border-stone-300">
                        </div>
                        <div>
                            <label class="text-sm font-medium text-stone-700">Rappel</label>
                            <input type="date" name="rappel_at" value="{{ old('rappel_at', $client->rappel_at?->format('Y-m-d')) }}" class="mt-1 w-full rounded-md border-stone-300">
                        </div>
                    </div>
                    <div class="mt-4 grid gap-4 lg:grid-cols-2">
                        <div>
                            <label class="text-sm font-medium text-stone-700">Préférences de style</label>
                            <textarea name="preferences_style" rows="3" class="mt-1 w-full rounded-md border-stone-300">{{ old('preferences_style', $client->preferences_style) }}</textarea>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-stone-700">Couleurs favorites</label>
                            <textarea name="couleurs_favorites" rows="3" class="mt-1 w-full rounded-md border-stone-300">{{ old('couleurs_favorites', $client->couleurs_favorites) }}</textarea>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-stone-700">Tissus préférés</label>
                            <textarea name="tissus_preferes" rows="3" class="mt-1 w-full rounded-md border-stone-300">{{ old('tissus_preferes', $client->tissus_preferes) }}</textarea>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-stone-700">Allergies / tissus à éviter</label>
                            <textarea name="allergies_tissus" rows="3" class="mt-1 w-full rounded-md border-stone-300">{{ old('allergies_tissus', $client->allergies_tissus) }}</textarea>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-stone-700">Instructions de livraison</label>
                            <textarea name="instructions_livraison" rows="3" class="mt-1 w-full rounded-md border-stone-300">{{ old('instructions_livraison', $client->instructions_livraison) }}</textarea>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-stone-700">Notes atelier</label>
                            <textarea name="notes" rows="3" class="mt-1 w-full rounded-md border-stone-300">{{ old('notes', $client->notes) }}</textarea>
                        </div>
                    </div>
                    <div class="mt-4 max-w-xs">
                        <label class="text-sm font-medium text-stone-700">Solde initial</label>
                        <input type="number" step="0.01" name="solde" value="{{ old('solde', $client->solde ?? 0) }}" class="mt-1 w-full rounded-md border-stone-300">
                    </div>
                </section>

                <section class="rounded-lg border border-[#eadfcc] bg-white p-6 shadow-sm">
                    <div class="flex flex-col gap-1 sm:flex-row sm:items-end sm:justify-between">
                        <div>
                            <h2 class="text-lg font-semibold text-[#3b2418]">Mensurations</h2>
                            <p class="text-sm text-stone-500">Valeurs en centimètres, sauf hauteur talon.</p>
                        </div>
                        <div class="grid gap-3 sm:grid-cols-2">
                            <div>
                                <label class="text-sm font-medium text-stone-700">Date de prise</label>
                                <input type="date" name="measurement[mesure_at]" value="{{ old('measurement.mesure_at', $measurement->mesure_at?->format('Y-m-d')) }}" class="mt-1 w-full rounded-md border-stone-300">
                            </div>
                            <div>
                                <label class="text-sm font-medium text-stone-700">Prise par</label>
                                <input name="measurement[prise_par]" value="{{ old('measurement.prise_par', $measurement->prise_par) }}" class="mt-1 w-full rounded-md border-stone-300">
                            </div>
                        </div>
                    </div>

                    @php
                        $measureFields = [
                            'tour_cou' => 'Tour cou',
                            'tour_poitrine' => 'Tour poitrine',
                            'tour_taille' => 'Tour taille',
                            'tour_hanches' => 'Tour hanches',
                            'epaule' => 'Épaule',
                            'carrure_dos' => 'Carrure dos',
                            'longueur_buste' => 'Longueur buste',
                            'longueur_robe' => 'Longueur robe',
                            'longueur_jupe' => 'Longueur jupe',
                            'longueur_boubou' => 'Longueur boubou',
                            'longueur_pantalon' => 'Longueur pantalon',
                            'entrejambe' => 'Entrejambe',
                            'longueur_manche' => 'Longueur manche',
                            'tour_bras' => 'Tour bras',
                            'tour_emmanchure' => 'Tour emmanchure',
                            'tour_poignet' => 'Tour poignet',
                            'tour_cuisse' => 'Tour cuisse',
                            'tour_genou' => 'Tour genou',
                            'tour_cheville' => 'Tour cheville',
                            'hauteur_talon' => 'Hauteur talon',
                        ];
                    @endphp

                    <div class="mt-5 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                        @foreach ($measureFields as $field => $label)
                            <div>
                                <label class="text-sm font-medium text-stone-700">{{ $label }}</label>
                                <input type="number" step="0.01" min="0" name="measurement[{{ $field }}]" value="{{ old('measurement.'.$field, $measurement->{$field}) }}" class="mt-1 w-full rounded-md border-stone-300">
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4">
                        <label class="text-sm font-medium text-stone-700">Notes mensurations</label>
                        <textarea name="measurement[notes]" rows="3" class="mt-1 w-full rounded-md border-stone-300">{{ old('measurement.notes', $measurement->notes) }}</textarea>
                    </div>
                </section>

                <div class="flex items-center justify-end gap-3">
                    <a href="{{ route('clients.index') }}" class="rounded-md border border-stone-300 px-4 py-2 text-sm font-semibold text-stone-700">Annuler</a>
                    <button class="rounded-md bg-[#7f1d1d] px-4 py-2 text-sm font-semibold text-white hover:bg-[#651616]">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
