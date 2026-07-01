<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Commande;
use App\Models\Facture;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FactureController extends Controller
{
    public function index(): View
    {
        return view('factures.index', [
            'factures' => Facture::with(['client', 'commande'])->latest()->paginate(12),
        ]);
    }

    public function create(): View
    {
        return view('factures.form', $this->formData(new Facture([
            'date_facture' => now(),
            'type' => 'definitive',
            'statut' => 'impayee',
        ])));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['numero'] = $data['numero'] ?: 'FAC-'.now()->format('Ymd').'-'.str_pad((string) (Facture::count() + 1), 4, '0', STR_PAD_LEFT);
        Facture::create($data);

        return redirect()->route('factures.index')->with('status', 'Facture créée.');
    }

    public function edit(Facture $facture): View
    {
        return view('factures.form', $this->formData($facture));
    }

    public function pdf(Facture $facture)
    {
        $facture->load(['client', 'commande']);

        return Pdf::loadView('documents.facture', $this->documentData($facture))
            ->setPaper('a4')
            ->stream($facture->numero.'.pdf');
    }

    public function print(Facture $facture): View
    {
        $facture->load(['client', 'commande']);

        return view('documents.facture', $this->documentData($facture) + ['printMode' => true]);
    }

    public function update(Request $request, Facture $facture): RedirectResponse
    {
        $facture->update($this->validated($request));

        return redirect()->route('factures.index')->with('status', 'Facture mise à jour.');
    }

    public function destroy(Facture $facture): RedirectResponse
    {
        $facture->delete();

        return redirect()->route('factures.index')->with('status', 'Facture supprimée.');
    }

    private function formData(Facture $facture): array
    {
        return [
            'facture' => $facture,
            'clients' => Client::orderBy('nom')->get(),
            'commandes' => Commande::with('client')->latest()->get(),
        ];
    }

    private function documentData(Facture $facture): array
    {
        return [
            'facture' => $facture,
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
            'commande_id' => ['nullable', 'exists:commandes,id'],
            'client_id' => ['required', 'exists:clients,id'],
            'numero' => ['nullable', 'string', 'max:80'],
            'type' => ['required', 'string', 'max:50'],
            'montant_total' => ['required', 'numeric', 'min:0'],
            'montant_paye' => ['nullable', 'numeric', 'min:0'],
            'statut' => ['required', 'string', 'max:50'],
            'date_facture' => ['nullable', 'date'],
            'date_echeance' => ['nullable', 'date'],
        ]);
    }
}
