<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StockController extends Controller
{
    public function index(): View
    {
        return view('stocks.index', [
            'stocks' => Stock::orderBy('categorie')->orderBy('nom')->paginate(12),
        ]);
    }

    public function create(): View
    {
        return view('stocks.form', ['stock' => new Stock()]);
    }

    public function store(Request $request): RedirectResponse
    {
        Stock::create($this->validated($request));

        return redirect()->route('stocks.index')->with('status', 'Article ajouté au stock.');
    }

    public function edit(Stock $stock): View
    {
        return view('stocks.form', compact('stock'));
    }

    public function update(Request $request, Stock $stock): RedirectResponse
    {
        $stock->update($this->validated($request));

        return redirect()->route('stocks.index')->with('status', 'Stock mis à jour.');
    }

    public function destroy(Stock $stock): RedirectResponse
    {
        $stock->delete();

        return redirect()->route('stocks.index')->with('status', 'Stock supprimé.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'categorie' => ['required', 'string', 'max:100'],
            'unite' => ['required', 'string', 'max:50'],
            'quantite' => ['required', 'numeric', 'min:0'],
            'seuil_alerte' => ['required', 'numeric', 'min:0'],
            'prix_unitaire' => ['nullable', 'numeric', 'min:0'],
            'fournisseur' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
        ]);
    }
}
