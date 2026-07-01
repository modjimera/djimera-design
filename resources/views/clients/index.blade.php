<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-semibold text-[#3b2418]">Clients</h1>
            <a href="{{ route('clients.create') }}" class="rounded-md bg-[#7f1d1d] px-4 py-2 text-sm font-semibold text-white hover:bg-[#651616]">Nouveau client</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-4 rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">{{ session('status') }}</div>
            @endif
            <div class="overflow-hidden rounded-lg border border-[#eadfcc] bg-white shadow-sm">
                <table class="min-w-full divide-y divide-[#eadfcc] text-sm">
                    <thead class="bg-[#fbf8f3] text-left text-stone-500">
                        <tr>
                            <th class="px-4 py-3">Nom</th>
                            <th class="px-4 py-3">Contact</th>
                            <th class="px-4 py-3">Style</th>
                            <th class="px-4 py-3">Commandes</th>
                            <th class="px-4 py-3 text-right">Solde</th>
                            <th class="px-4 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100">
                        @forelse ($clients as $client)
                            <tr>
                                <td class="px-4 py-3">
                                    <div class="font-medium text-[#3b2418]">{{ $client->nom }}</div>
                                    <div class="text-xs text-stone-500">{{ $client->source ?? 'Source non renseignée' }}</div>
                                </td>
                                <td class="px-4 py-3">
                                    <div>{{ $client->telephone ?? '-' }}</div>
                                    <div class="text-xs text-stone-500">{{ $client->whatsapp ?? $client->email ?? '-' }}</div>
                                </td>
                                <td class="px-4 py-3">
                                    <div>{{ $client->taille_habit ?? '-' }}</div>
                                    <div class="text-xs text-stone-500">{{ $client->morphologie ?? '-' }}</div>
                                </td>
                                <td class="px-4 py-3">{{ $client->commandes_count }}</td>
                                <td class="px-4 py-3 text-right">{{ number_format($client->solde, 0, ',', ' ') }} FCFA</td>
                                <td class="px-4 py-3 text-right">
                                    <a href="{{ route('clients.show', $client) }}" class="font-semibold text-[#7f1d1d] hover:underline">Voir</a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-4 py-8 text-center text-stone-500">Aucun client enregistré.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $clients->links() }}</div>
        </div>
    </div>
</x-app-layout>
