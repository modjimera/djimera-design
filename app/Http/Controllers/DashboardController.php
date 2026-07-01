<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Commande;
use App\Models\Depense;
use App\Models\Facture;
use App\Models\Paiement;
use App\Models\Stock;
use Carbon\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $encaissements = Paiement::whereBetween('date_paiement', [$startOfMonth, $endOfMonth])->sum('montant');
        $decaissements = Depense::whereBetween('date_depense', [$startOfMonth, $endOfMonth])->sum('montant');

        return view('dashboard', [
            'stats' => [
                'clients' => Client::count(),
                'ca_mois' => Commande::whereBetween('date_commande', [$startOfMonth, $endOfMonth])->sum('prix_convenu'),
                'commandes_en_cours' => Commande::whereNotIn('statut', ['Livrée', 'Annulée'])->count(),
                'commandes_livrees' => Commande::where('statut', 'Livrée')->count(),
                'factures_impayees' => Facture::whereIn('statut', ['impayee', 'partielle'])->count(),
                'encaissements' => $encaissements,
                'decaissements' => $decaissements,
                'benefice_estime' => $encaissements - $decaissements,
                'stock_faible' => Stock::whereColumn('quantite', '<=', 'seuil_alerte')->count(),
            ],
            'livraisons' => Commande::with('client')
                ->whereNotIn('statut', ['Livrée', 'Annulée'])
                ->whereDate('date_livraison_prevue', '<=', Carbon::now()->addDays(7))
                ->orderBy('date_livraison_prevue')
                ->limit(6)
                ->get(),
            'stocksFaibles' => Stock::whereColumn('quantite', '<=', 'seuil_alerte')
                ->orderBy('quantite')
                ->limit(6)
                ->get(),
            'commandesRecentes' => Commande::with('client')
                ->latest()
                ->limit(6)
                ->get(),
        ]);
    }
}
