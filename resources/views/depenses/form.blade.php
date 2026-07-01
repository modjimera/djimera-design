<x-app-layout>
    <x-slot name="header"><h1 class="text-2xl font-semibold text-[#3b2418]">{{ $depense->exists ? 'Modifier la dépense' : 'Nouvelle dépense' }}</h1></x-slot>
    <div class="py-8"><div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8"><form method="POST" action="{{ $depense->exists ? route('depenses.update', $depense) : route('depenses.store') }}" class="space-y-6 rounded-lg border border-[#eadfcc] bg-white p-6 shadow-sm">@csrf @if($depense->exists) @method('PUT') @endif
        <div class="grid gap-4 sm:grid-cols-2">
            <input name="libelle" value="{{ old('libelle', $depense->libelle) }}" required placeholder="Libellé" class="rounded-md border-stone-300">
            <select name="categorie" class="rounded-md border-stone-300">@foreach(['achat tissus','achat accessoires','paiement tailleurs','loyer','transport','communication','shooting photo','charges diverses'] as $cat)<option value="{{ $cat }}" @selected(old('categorie', $depense->categorie ?? 'charges diverses') === $cat)>{{ ucfirst($cat) }}</option>@endforeach</select>
            <input type="number" step="0.01" name="montant" value="{{ old('montant', $depense->montant ?? 0) }}" required placeholder="Montant" class="rounded-md border-stone-300">
            <select name="moyen" class="rounded-md border-stone-300">@foreach(['especes','mobile money','virement','carte bancaire'] as $moyen)<option value="{{ $moyen }}" @selected(old('moyen', $depense->moyen ?? 'especes') === $moyen)>{{ ucfirst($moyen) }}</option>@endforeach</select>
            <input type="date" name="date_depense" value="{{ old('date_depense', $depense->date_depense?->format('Y-m-d')) }}" class="rounded-md border-stone-300">
        </div><textarea name="notes" rows="3" placeholder="Notes" class="w-full rounded-md border-stone-300">{{ old('notes', $depense->notes) }}</textarea>
        <div class="flex justify-end gap-3"><a href="{{ route('depenses.index') }}" class="rounded-md border border-stone-300 px-4 py-2 text-sm font-semibold">Annuler</a><button class="rounded-md bg-[#7f1d1d] px-4 py-2 text-sm font-semibold text-white">Enregistrer</button></div>
    </form></div></div>
</x-app-layout>
