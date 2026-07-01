<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        return view('users.index', [
            'users' => User::latest()->paginate(12),
        ]);
    }

    public function create(): View
    {
        return view('users.form', [
            'user' => new User(['role' => 'Gérante', 'statut' => 'actif']),
            'roles' => User::ROLES,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        User::create($this->validated($request));

        return redirect()->route('users.index')->with('status', 'Utilisateur créé.');
    }

    public function edit(User $user): View
    {
        return view('users.form', [
            'user' => $user,
            'roles' => User::ROLES,
        ]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $data = $this->validated($request, $user);

        if (blank($data['password'] ?? null)) {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('status', 'Utilisateur mis à jour.');
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        if ($request->user()->is($user)) {
            return redirect()->route('users.index')->with('status', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('status', 'Utilisateur supprimé.');
    }

    private function validated(Request $request, ?User $user = null): array
    {
        $passwordRules = $user?->exists
            ? ['nullable', 'string', 'min:8', 'confirmed']
            : ['required', 'string', 'min:8', 'confirmed'];

        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user)],
            'role' => ['required', Rule::in(User::ROLES)],
            'telephone' => ['nullable', 'string', 'max:50'],
            'statut' => ['required', Rule::in(['actif', 'inactif'])],
            'password' => $passwordRules,
        ]);
    }
}
