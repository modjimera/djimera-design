<?php

namespace App\Http\Controllers;

use App\Models\Depense;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DepenseController extends Controller
{
    public function index(): View
    {
        return view('depenses.index', [
            'depenses' => Depense::latest()->paginate(12),
        ]);
    }

    public function create(): View
    {
        return view('depenses.form', ['depense' => new Depense(['date_depense' => now()])]);
    }

    public function store(Request $request): RedirectResponse
    {
        Depense::create($this->validated($request));

        return redirect()->route('depenses.index')->with('status', 'Dépense enregistrée.');
    }

    public function edit(Depense $depense): View
    {
        return view('depenses.form', compact('depense'));
    }

    public function update(Request $request, Depense $depense): RedirectResponse
    {
        $depense->update($this->validated($request));

        return redirect()->route('depenses.index')->with('status', 'Dépense mise à jour.');
    }

    public function destroy(Depense $depense): RedirectResponse
    {
        $depense->delete();

        return redirect()->route('depenses.index')->with('status', 'Dépense supprimée.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'libelle' => ['required', 'string', 'max:255'],
            'categorie' => ['required', 'string', 'max:255'],
            'montant' => ['required', 'numeric', 'min:0'],
            'moyen' => ['required', 'string', 'max:50'],
            'date_depense' => ['nullable', 'date'],
            'notes' => ['nullable', 'string'],
        ]);
    }
}
