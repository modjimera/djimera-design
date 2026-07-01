<x-app-layout>
    <x-slot name="header"><h1 class="text-2xl font-semibold text-[#3b2418]">{{ $facture->exists ? 'Modifier la facture' : 'Nouvelle facture' }}</h1></x-slot>
    <div class="py-8"><div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
        <form method="POST" action="{{ $facture->exists ? route('factures.update', $facture) : route('factures.store') }}" class="space-y-6 rounded-lg border border-[#eadfcc] bg-white p-6 shadow-sm">@csrf @if($facture->exists) @method('PUT') @endif
            <div class="grid gap-4 sm:grid-cols-2">
                <select name="client_id" required class="rounded-md border-stone-300"><option value="">Client</option>@foreach($clients as $client)<option value="{{ $client->id }}" @selected(old('client_id', request('client_id', $facture->client_id)) == $client->id)>{{ $client->nom }}</option>@endforeach</select>
                <select name="commande_id" class="rounded-md border-stone-300"><option value="">Commande liée</option>@foreach($commandes as $commande)<option value="{{ $commande->id }}" @selected(old('commande_id', request('commande_id', $facture->commande_id)) == $commande->id)>{{ $commande->numero }} - {{ $commande->client?->nom }}</option>@endforeach</select>
                <input name="numero" value="{{ old('numero', $facture->numero) }}" placeholder="Numéro auto" class="rounded-md border-stone-300">
                <select name="type" class="rounded-md border-stone-300"><option value="proforma" @selected(old('type', $facture->type) === 'proforma')>Proforma</option><option value="definitive" @selected(old('type', $facture->type ?? 'definitive') === 'definitive')>Définitive</option></select>
                <input type="number" step="0.01" name="montant_total" value="{{ old('montant_total', $facture->montant_total ?? 0) }}" placeholder="Montant total" class="rounded-md border-stone-300">
                <input type="number" step="0.01" name="montant_paye" value="{{ old('montant_paye', $facture->montant_paye ?? 0) }}" placeholder="Montant payé" class="rounded-md border-stone-300">
                <select name="statut" class="rounded-md border-stone-300">@foreach(['impayee','partielle','payee'] as $statut)<option value="{{ $statut }}" @selected(old('statut', $facture->statut ?? 'impayee') === $statut)>{{ ucfirst($statut) }}</option>@endforeach</select>
                <input type="date" name="date_facture" value="{{ old('date_facture', $facture->date_facture?->format('Y-m-d')) }}" class="rounded-md border-stone-300">
                <input type="date" name="date_echeance" value="{{ old('date_echeance', $facture->date_echeance?->format('Y-m-d')) }}" class="rounded-md border-stone-300">
            </div>
            <div class="flex justify-end gap-3"><a href="{{ route('factures.index') }}" class="rounded-md border border-stone-300 px-4 py-2 text-sm font-semibold">Annuler</a><button class="rounded-md bg-[#7f1d1d] px-4 py-2 text-sm font-semibold text-white">Enregistrer</button></div>
        </form>
    </div></div>
</x-app-layout>
