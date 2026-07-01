<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-semibold text-[#3b2418]">Commandes</h1>
            <a href="{{ route('commandes.create') }}" class="rounded-md bg-[#7f1d1d] px-4 py-2 text-sm font-semibold text-white hover:bg-[#651616]">Nouvelle commande</a>
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
                            <th class="px-4 py-3">N°</th>
                            <th class="px-4 py-3">Client</th>
                            <th class="px-4 py-3">Tenue</th>
                            <th class="px-4 py-3">Statut</th>
                            <th class="px-4 py-3">Livraison</th>
                            <th class="px-4 py-3 text-right">Reste</th>
                            <th class="px-4 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100">
                        @forelse ($commandes as $commande)
                            <tr>
                                <td class="px-4 py-3 font-medium text-[#3b2418]">{{ $commande->numero }}</td>
                                <td class="px-4 py-3">{{ $commande->client?->nom }}</td>
                                <td class="px-4 py-3">{{ $commande->type_tenue ?? '-' }}</td>
                                <td class="px-4 py-3">{{ $commande->statut }}</td>
                                <td class="px-4 py-3">{{ $commande->date_livraison_prevue?->format('d/m/Y') ?? '-' }}</td>
                                <td class="px-4 py-3 text-right">{{ number_format($commande->reste_a_payer, 0, ',', ' ') }} FCFA</td>
                                <td class="px-4 py-3 text-right"><a href="{{ route('commandes.show', $commande) }}" class="text-[#7f1d1d] hover:underline">Voir</a></td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="px-4 py-8 text-center text-stone-500">Aucune commande enregistrée.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $commandes->links() }}</div>
        </div>
    </div>
</x-app-layout>
