<x-app-layout>
    <x-slot name="header"><h1 class="text-2xl font-semibold text-[#3b2418]">{{ $member->exists ? 'Modifier le membre' : 'Nouveau membre atelier' }}</h1></x-slot>
    <div class="py-8"><div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8"><form method="POST" action="{{ $member->exists ? route('staff.update', $member) : route('staff.store') }}" class="space-y-6 rounded-lg border border-[#eadfcc] bg-white p-6 shadow-sm">@csrf @if($member->exists) @method('PUT') @endif
        <div class="grid gap-4 sm:grid-cols-2">
            <input name="nom" value="{{ old('nom', $member->nom) }}" required placeholder="Nom" class="rounded-md border-stone-300">
            <select name="role" class="rounded-md border-stone-300">@foreach(['styliste','couturier','brodeur','livreur','caissière','prestataire'] as $role)<option value="{{ $role }}" @selected(old('role', $member->role) === $role)>{{ ucfirst($role) }}</option>@endforeach</select>
            <input name="telephone" value="{{ old('telephone', $member->telephone) }}" placeholder="Téléphone" class="rounded-md border-stone-300">
            <input type="number" step="0.01" name="tarif" value="{{ old('tarif', $member->tarif ?? 0) }}" placeholder="Tarif" class="rounded-md border-stone-300">
            <select name="statut" class="rounded-md border-stone-300"><option value="actif" @selected(old('statut', $member->statut ?? 'actif') === 'actif')>Actif</option><option value="inactif" @selected(old('statut', $member->statut) === 'inactif')>Inactif</option></select>
        </div><textarea name="notes" rows="3" placeholder="Notes" class="w-full rounded-md border-stone-300">{{ old('notes', $member->notes) }}</textarea>
        <div class="flex justify-end gap-3"><a href="{{ route('staff.index') }}" class="rounded-md border border-stone-300 px-4 py-2 text-sm font-semibold">Annuler</a><button class="rounded-md bg-[#7f1d1d] px-4 py-2 text-sm font-semibold text-white">Enregistrer</button></div>
    </form></div></div>
</x-app-layout>
