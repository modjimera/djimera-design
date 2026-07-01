<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-semibold text-[#3b2418]">{{ $modele->exists ? 'Modifier le modèle' : 'Nouveau modèle' }}</h1>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
            <form method="POST" enctype="multipart/form-data" action="{{ $modele->exists ? route('modeles.update', $modele) : route('modeles.store') }}" class="space-y-6 rounded-lg border border-[#eadfcc] bg-white p-6 shadow-sm">
                @csrf
                @if ($modele->exists)
                    @method('PUT')
                @endif

                <div class="grid gap-6 lg:grid-cols-[280px_1fr]">
                    <section>
                        <label class="text-sm font-medium text-stone-700">Image du modèle</label>
                        <div class="mt-2 overflow-hidden rounded-lg border border-[#eadfcc] bg-[#fbf8f3]">
                            @if ($modele->photo_path)
                                <img src="{{ asset('storage/'.$modele->photo_path) }}" alt="{{ $modele->nom }}" class="aspect-[4/5] w-full object-cover">
                            @else
                                <div class="flex aspect-[4/5] items-center justify-center px-6 text-center text-sm text-stone-500">
                                    Aucune image
                                </div>
                            @endif
                        </div>
                        <input type="file" name="photo" accept="image/*" class="mt-3 block w-full text-sm text-stone-700 file:mr-4 file:rounded-md file:border-0 file:bg-[#7f1d1d] file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white">
                        @error('photo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror

                        @if ($modele->photo_path)
                            <label class="mt-3 flex items-center gap-2 text-sm text-stone-700">
                                <input type="checkbox" name="remove_photo" value="1" class="rounded border-stone-300">
                                Retirer l’image actuelle
                            </label>
                        @endif
                    </section>

                    <section class="space-y-4">
                        <div class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <label class="text-sm font-medium text-stone-700">Nom du modèle</label>
                                <input name="nom" value="{{ old('nom', $modele->nom) }}" required class="mt-1 w-full rounded-md border-stone-300">
                            </div>
                            <div>
                                <label class="text-sm font-medium text-stone-700">Catégorie</label>
                                <input name="categorie" value="{{ old('categorie', $modele->categorie) }}" placeholder="Robe, boubou, mariage..." class="mt-1 w-full rounded-md border-stone-300">
                            </div>
                            <div>
                                <label class="text-sm font-medium text-stone-700">Tissu recommandé</label>
                                <input name="tissu_recommande" value="{{ old('tissu_recommande', $modele->tissu_recommande) }}" class="mt-1 w-full rounded-md border-stone-300">
                            </div>
                            <div>
                                <label class="text-sm font-medium text-stone-700">Prix indicatif</label>
                                <input type="number" step="0.01" name="prix_indicatif" value="{{ old('prix_indicatif', $modele->prix_indicatif ?? 0) }}" class="mt-1 w-full rounded-md border-stone-300">
                            </div>
                            <div>
                                <label class="text-sm font-medium text-stone-700">Temps estimé en heures</label>
                                <input type="number" name="temps_estime_heures" value="{{ old('temps_estime_heures', $modele->temps_estime_heures) }}" class="mt-1 w-full rounded-md border-stone-300">
                            </div>
                            <div>
                                <label class="text-sm font-medium text-stone-700">Difficulté</label>
                                <select name="niveau_difficulte" class="mt-1 w-full rounded-md border-stone-300">
                                    @foreach (['facile', 'moyen', 'difficile', 'expert'] as $niveau)
                                        <option value="{{ $niveau }}" @selected(old('niveau_difficulte', $modele->niveau_difficulte ?? 'moyen') === $niveau)>{{ ucfirst($niveau) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <label class="flex items-center gap-2 text-sm text-stone-700">
                            <input type="checkbox" name="favori" value="1" @checked(old('favori', $modele->favori)) class="rounded border-stone-300">
                            Modèle favori
                        </label>

                        <div>
                            <label class="text-sm font-medium text-stone-700">Description</label>
                            <textarea name="description" rows="5" class="mt-1 w-full rounded-md border-stone-300">{{ old('description', $modele->description) }}</textarea>
                        </div>
                    </section>
                </div>

                <div class="flex justify-end gap-3">
                    <a href="{{ route('modeles.index') }}" class="rounded-md border border-stone-300 px-4 py-2 text-sm font-semibold text-stone-700">Annuler</a>
                    <button class="rounded-md bg-[#7f1d1d] px-4 py-2 text-sm font-semibold text-white hover:bg-[#651616]">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
