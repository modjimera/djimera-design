<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-semibold text-[#3b2418]">{{ $user->exists ? 'Modifier l’utilisateur' : 'Nouvel utilisateur' }}</h1>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <form method="POST" action="{{ $user->exists ? route('users.update', $user) : route('users.store') }}" class="space-y-6 rounded-lg border border-[#eadfcc] bg-white p-6 shadow-sm">
                @csrf
                @if ($user->exists)
                    @method('PUT')
                @endif

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="text-sm font-medium text-stone-700">Nom</label>
                        <input name="name" value="{{ old('name', $user->name) }}" required class="mt-1 w-full rounded-md border-stone-300">
                        @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="text-sm font-medium text-stone-700">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="mt-1 w-full rounded-md border-stone-300">
                        @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="text-sm font-medium text-stone-700">Téléphone</label>
                        <input name="telephone" value="{{ old('telephone', $user->telephone) }}" class="mt-1 w-full rounded-md border-stone-300">
                    </div>
                    <div>
                        <label class="text-sm font-medium text-stone-700">Rôle</label>
                        <select name="role" required class="mt-1 w-full rounded-md border-stone-300">
                            @foreach ($roles as $role)
                                <option value="{{ $role }}" @selected(old('role', $user->role) === $role)>{{ $role }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-stone-700">Statut</label>
                        <select name="statut" required class="mt-1 w-full rounded-md border-stone-300">
                            <option value="actif" @selected(old('statut', $user->statut ?? 'actif') === 'actif')>Actif</option>
                            <option value="inactif" @selected(old('statut', $user->statut) === 'inactif')>Inactif</option>
                        </select>
                    </div>
                </div>

                <div class="rounded-md border border-[#eadfcc] bg-[#fbf8f3] p-4">
                    <h2 class="text-sm font-semibold text-[#3b2418]">Mot de passe</h2>
                    @if ($user->exists)
                        <p class="mt-1 text-sm text-stone-500">Laissez vide pour conserver le mot de passe actuel.</p>
                    @endif
                    <div class="mt-4 grid gap-4 sm:grid-cols-2">
                        <div>
                            <label class="text-sm font-medium text-stone-700">Mot de passe</label>
                            <input type="password" name="password" @required(! $user->exists) class="mt-1 w-full rounded-md border-stone-300">
                            @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="text-sm font-medium text-stone-700">Confirmation</label>
                            <input type="password" name="password_confirmation" @required(! $user->exists) class="mt-1 w-full rounded-md border-stone-300">
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-3">
                    <a href="{{ route('users.index') }}" class="rounded-md border border-stone-300 px-4 py-2 text-sm font-semibold text-stone-700">Annuler</a>
                    <button class="rounded-md bg-[#7f1d1d] px-4 py-2 text-sm font-semibold text-white hover:bg-[#651616]">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
