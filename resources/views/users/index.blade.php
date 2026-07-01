<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-[#3b2418]">Utilisateurs</h1>
                <p class="text-sm text-stone-600">Comptes d’accès à l’application Djiméra Design Manager.</p>
            </div>
            <a href="{{ route('users.create') }}" class="rounded-md bg-[#7f1d1d] px-4 py-2 text-sm font-semibold text-white hover:bg-[#651616]">Nouvel utilisateur</a>
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
                            <th class="px-4 py-3">Email</th>
                            <th class="px-4 py-3">Téléphone</th>
                            <th class="px-4 py-3">Rôle</th>
                            <th class="px-4 py-3">Statut</th>
                            <th class="px-4 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100">
                        @forelse ($users as $user)
                            <tr>
                                <td class="px-4 py-3 font-medium text-[#3b2418]">
                                    {{ $user->name }}
                                    @if (auth()->id() === $user->id)
                                        <span class="ml-2 rounded-full bg-[#c69c48]/20 px-2 py-1 text-xs text-[#6f4b2f]">Vous</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">{{ $user->email }}</td>
                                <td class="px-4 py-3">{{ $user->telephone ?? '-' }}</td>
                                <td class="px-4 py-3">{{ $user->role }}</td>
                                <td class="px-4 py-3">
                                    <span class="rounded-full px-2 py-1 text-xs font-semibold {{ $user->statut === 'actif' ? 'bg-emerald-50 text-emerald-700' : 'bg-stone-100 text-stone-600' }}">
                                        {{ ucfirst($user->statut) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex justify-end gap-3">
                                        <a href="{{ route('users.edit', $user) }}" class="font-semibold text-[#7f1d1d]">Modifier</a>
                                        @if (auth()->id() !== $user->id)
                                            <form method="POST" action="{{ route('users.destroy', $user) }}" onsubmit="return confirm('Supprimer cet utilisateur ?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="text-stone-600 hover:text-red-700">Supprimer</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-4 py-8 text-center text-stone-500">Aucun utilisateur enregistré.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $users->links() }}</div>
        </div>
    </div>
</x-app-layout>
