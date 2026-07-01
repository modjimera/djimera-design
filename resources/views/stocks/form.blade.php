<x-app-layout>
    <x-slot name="header"><h1 class="text-2xl font-semibold text-[#3b2418]">{{ $stock->exists ? 'Modifier le stock' : 'Nouvel article stock' }}</h1></x-slot>
    <div class="py-8"><div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8"><form method="POST" action="{{ $stock->exists ? route('stocks.update', $stock) : route('stocks.store') }}" class="space-y-6 rounded-lg border border-[#eadfcc] bg-white p-6 shadow-sm">@csrf @if($stock->exists) @method('PUT') @endif
        <div class="grid gap-4 sm:grid-cols-2">
            <input name="nom" value="{{ old('nom', $stock->nom) }}" required placeholder="Nom" class="rounded-md border-stone-300">
            <select name="categorie" class="rounded-md border-stone-300">@foreach(['tissu','fil','bouton','perle','dentelle','emballage','accessoire'] as $cat)<option value="{{ $cat }}" @selected(old('categorie', $stock->categorie ?? 'tissu') === $cat)>{{ ucfirst($cat) }}</option>@endforeach</select>
            <input name="unite" value="{{ old('unite', $stock->unite ?? 'metre') }}" required placeholder="Unité" class="rounded-md border-stone-300">
            <input type="number" step="0.01" name="quantite" value="{{ old('quantite', $stock->quantite ?? 0) }}" required placeholder="Quantité" class="rounded-md border-stone-300">
            <input type="number" step="0.01" name="seuil_alerte" value="{{ old('seuil_alerte', $stock->seuil_alerte ?? 0) }}" required placeholder="Seuil d'alerte" class="rounded-md border-stone-300">
            <input type="number" step="0.01" name="prix_unitaire" value="{{ old('prix_unitaire', $stock->prix_unitaire ?? 0) }}" placeholder="Prix unitaire" class="rounded-md border-stone-300">
            <input name="fournisseur" value="{{ old('fournisseur', $stock->fournisseur) }}" placeholder="Fournisseur" class="rounded-md border-stone-300">
        </div><textarea name="notes" rows="3" placeholder="Notes" class="w-full rounded-md border-stone-300">{{ old('notes', $stock->notes) }}</textarea>
        <div class="flex justify-end gap-3"><a href="{{ route('stocks.index') }}" class="rounded-md border border-stone-300 px-4 py-2 text-sm font-semibold">Annuler</a><button class="rounded-md bg-[#7f1d1d] px-4 py-2 text-sm font-semibold text-white">Enregistrer</button></div>
    </form></div></div>
</x-app-layout>
