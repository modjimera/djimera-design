<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-semibold text-[#3b2418]">Encaissements</h1>
            <a href="{{ route('paiements.create') }}" class="rounded-md bg-[#7f1d1d] px-4 py-2 text-sm font-semibold text-white">Nouveau paiement</a>
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
                            <th class="px-4 py-3">Date</th>
                            <th class="px-4 py-3">Client</th>
                            <th class="px-4 py-3">Type</th>
                            <th class="px-4 py-3">Moyen</th>
                            <th class="px-4 py-3 text-right">Montant</th>
                            <th class="px-4 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100">
                        @forelse ($paiements as $paiement)
                            <tr>
                                <td class="px-4 py-3">{{ $paiement->date_paiement?->format('d/m/Y') ?? '-' }}</td>
                                <td class="px-4 py-3">{{ $paiement->client?->nom }}</td>
                                <td class="px-4 py-3">{{ $paiement->type }}</td>
                                <td class="px-4 py-3">{{ $paiement->moyen }}</td>
                                <td class="px-4 py-3 text-right">{{ number_format($paiement->montant, 0, ',', ' ') }} FCFA</td>
                                <td class="px-4 py-3">
                                    <div class="flex justify-end gap-3">
                                        <a href="{{ route('paiements.pdf', $paiement) }}" target="_blank" class="font-semibold text-[#7f1d1d]">PDF</a>
                                        <a href="{{ route('paiements.print', $paiement) }}" target="_blank" class="font-semibold text-[#7f1d1d]">Imprimer</a>
                                        <a href="{{ route('paiements.edit', $paiement) }}" class="text-stone-600">Modifier</a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-4 py-8 text-center text-stone-500">Aucun paiement.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $paiements->links() }}</div>
        </div>
    </div>
</x-app-layout>
