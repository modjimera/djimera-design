<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Commande;
use App\Models\Modele;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CommandeController extends Controller
{
    public function index(): View
    {
        return view('commandes.index', [
            'commandes' => Commande::with('client')->latest()->paginate(12),
        ]);
    }

    public function create(): View
    {
        return view('commandes.form', $this->formData(new Commande([
            'date_commande' => now(),
            'date_livraison_prevue' => now()->addDays(14),
            'statut' => 'Nouvelle commande',
        ])));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['numero'] = $data['numero'] ?: 'CMD-'.now()->format('Ymd').'-'.str_pad((string) (Commande::count() + 1), 4, '0', STR_PAD_LEFT);
        $commande = Commande::create($data);

        return redirect()->route('commandes.show', $commande)->with('status', 'Commande créée.');
    }

    public function show(Commande $commande): View
    {
        $commande->load(['client', 'modele', 'facture', 'paiements']);

        return view('commandes.show', compact('commande'));
    }

    public function edit(Commande $commande): View
    {
        return view('commandes.form', $this->formData($commande));
    }

    public function update(Request $request, Commande $commande): RedirectResponse
    {
        $commande->update($this->validated($request));

        return redirect()->route('commandes.show', $commande)->with('status', 'Commande mise à jour.');
    }

    public function destroy(Commande $commande): RedirectResponse
    {
        $commande->delete();

        return redirect()->route('commandes.index')->with('status', 'Commande supprimée.');
    }

    private function formData(Commande $commande): array
    {
        return [
            'commande' => $commande,
            'clients' => Client::orderBy('nom')->get(),
            'modeles' => Modele::orderBy('nom')->get(),
            'statuts' => Commande::STATUTS,
        ];
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'client_id' => ['required', 'exists:clients,id'],
            'modele_id' => ['nullable', 'exists:modeles,id'],
            'numero' => ['nullable', 'string', 'max:80'],
            'modele_demande' => ['nullable', 'string', 'max:255'],
            'type_tenue' => ['nullable', 'string', 'max:255'],
            'tissu_utilise' => ['nullable', 'string', 'max:255'],
            'prix_convenu' => ['required', 'numeric', 'min:0'],
            'avance_versee' => ['nullable', 'numeric', 'min:0'],
            'date_commande' => ['nullable', 'date'],
            'date_livraison_prevue' => ['nullable', 'date'],
            'statut' => ['required', 'string', 'max:80'],
            'notes' => ['nullable', 'string'],
        ]);
    }
}
