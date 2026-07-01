<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Commande;
use App\Models\Facture;
use App\Models\Paiement;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaiementController extends Controller
{
    public function index(): View
    {
        return view('paiements.index', [
            'paiements' => Paiement::with(['client', 'commande'])->latest()->paginate(12),
        ]);
    }

    public function create(): View
    {
        return view('paiements.form', $this->formData(new Paiement(['date_paiement' => now()])));
    }

    public function store(Request $request): RedirectResponse
    {
        $paiement = Paiement::create($this->validated($request));
        $this->syncAmounts($paiement);

        return redirect()->route('paiements.index')->with('status', 'Paiement enregistré.');
    }

    public function edit(Paiement $paiement): View
    {
        return view('paiements.form', $this->formData($paiement));
    }

    public function pdf(Paiement $paiement)
    {
        $paiement->load(['client', 'commande', 'facture']);

        return Pdf::loadView('documents.recu', $this->documentData($paiement))
            ->setPaper('a4')
            ->stream('recu-'.$paiement->id.'.pdf');
    }

    public function print(Paiement $paiement): View
    {
        $paiement->load(['client', 'commande', 'facture']);

        return view('documents.recu', $this->documentData($paiement) + ['printMode' => true]);
    }

    public function update(Request $request, Paiement $paiement): RedirectResponse
    {
        $paiement->update($this->validated($request));
        $this->syncAmounts($paiement);

        return redirect()->route('paiements.index')->with('status', 'Paiement mis à jour.');
    }

    public function destroy(Paiement $paiement): RedirectResponse
    {
        $paiement->delete();

        return redirect()->route('paiements.index')->with('status', 'Paiement supprimé.');
    }

    private function formData(Paiement $paiement): array
    {
        return [
            'paiement' => $paiement,
            'clients' => Client::orderBy('nom')->get(),
            'commandes' => Commande::with('client')->latest()->get(),
            'factures' => Facture::with('client')->latest()->get(),
        ];
    }

    private function documentData(Paiement $paiement): array
    {
        return [
            'paiement' => $paiement,
            'logoDataUri' => $this->logoDataUri(),
            'printMode' => false,
        ];
    }

    private function logoDataUri(): string
    {
        $path = public_path('images/djimera-logo.png');

        return file_exists($path) ? 'data:image/png;base64,'.base64_encode(file_get_contents($path)) : '';
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'client_id' => ['required', 'exists:clients,id'],
            'commande_id' => ['nullable', 'exists:commandes,id'],
            'facture_id' => ['nullable', 'exists:factures,id'],
            'montant' => ['required', 'numeric', 'min:0'],
            'type' => ['required', 'string', 'max:50'],
            'moyen' => ['required', 'string', 'max:50'],
            'date_paiement' => ['nullable', 'date'],
            'notes' => ['nullable', 'string'],
        ]);
    }

    private function syncAmounts(Paiement $paiement): void
    {
        if ($paiement->commande) {
            $paiement->commande->update([
                'avance_versee' => $paiement->commande->paiements()->sum('montant'),
            ]);
        }

        if ($paiement->facture) {
            $montantPaye = $paiement->facture->paiements()->sum('montant');
            $paiement->facture->update([
                'montant_paye' => $montantPaye,
                'statut' => $montantPaye <= 0 ? 'impayee' : ($montantPaye < $paiement->facture->montant_total ? 'partielle' : 'payee'),
            ]);
        }
    }
}
