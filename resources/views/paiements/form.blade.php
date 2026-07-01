<x-app-layout>
    <x-slot name="header"><h1 class="text-2xl font-semibold text-[#3b2418]">{{ $paiement->exists ? 'Modifier le paiement' : 'Nouveau paiement' }}</h1></x-slot>
    <div class="py-8"><div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8"><form method="POST" action="{{ $paiement->exists ? route('paiements.update', $paiement) : route('paiements.store') }}" class="space-y-6 rounded-lg border border-[#eadfcc] bg-white p-6 shadow-sm">@csrf @if($paiement->exists) @method('PUT') @endif
        <div class="grid gap-4 sm:grid-cols-2">
            <select name="client_id" required class="rounded-md border-stone-300"><option value="">Client</option>@foreach($clients as $client)<option value="{{ $client->id }}" @selected(old('client_id', request('client_id', $paiement->client_id)) == $client->id)>{{ $client->nom }}</option>@endforeach</select>
            <select name="commande_id" class="rounded-md border-stone-300"><option value="">Commande</option>@foreach($commandes as $commande)<option value="{{ $commande->id }}" @selected(old('commande_id', request('commande_id', $paiement->commande_id)) == $commande->id)>{{ $commande->numero }} - {{ $commande->client?->nom }}</option>@endforeach</select>
            <select name="facture_id" class="rounded-md border-stone-300"><option value="">Facture</option>@foreach($factures as $facture)<option value="{{ $facture->id }}" @selected(old('facture_id', $paiement->facture_id) == $facture->id)>{{ $facture->numero }} - {{ $facture->client?->nom }}</option>@endforeach</select>
            <input type="number" step="0.01" name="montant" value="{{ old('montant', $paiement->montant ?? 0) }}" required placeholder="Montant" class="rounded-md border-stone-300">
            <select name="type" class="rounded-md border-stone-300">@foreach(['avance','solde','paiement client'] as $type)<option value="{{ $type }}" @selected(old('type', $paiement->type ?? 'avance') === $type)>{{ ucfirst($type) }}</option>@endforeach</select>
            <select name="moyen" class="rounded-md border-stone-300">@foreach(['especes','mobile money','virement','carte bancaire'] as $moyen)<option value="{{ $moyen }}" @selected(old('moyen', $paiement->moyen ?? 'especes') === $moyen)>{{ ucfirst($moyen) }}</option>@endforeach</select>
            <input type="date" name="date_paiement" value="{{ old('date_paiement', $paiement->date_paiement?->format('Y-m-d')) }}" class="rounded-md border-stone-300">
        </div><textarea name="notes" rows="3" placeholder="Notes" class="w-full rounded-md border-stone-300">{{ old('notes', $paiement->notes) }}</textarea>
        <div class="flex justify-end gap-3"><a href="{{ route('paiements.index') }}" class="rounded-md border border-stone-300 px-4 py-2 text-sm font-semibold">Annuler</a><button class="rounded-md bg-[#7f1d1d] px-4 py-2 text-sm font-semibold text-white">Enregistrer</button></div>
    </form></div></div>
</x-app-layout>
