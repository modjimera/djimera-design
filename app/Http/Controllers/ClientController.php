<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ClientMeasurement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClientController extends Controller
{
    public function index(): View
    {
        return view('clients.index', [
            'clients' => Client::withCount('commandes')->latest()->paginate(12),
        ]);
    }

    public function create(): View
    {
        return view('clients.form', [
            'client' => new Client(),
            'measurement' => new ClientMeasurement(['mesure_at' => now()]),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        [$clientData, $measurementData] = $this->validated($request);

        $client = Client::create($clientData);
        $this->saveMeasurement($client, $measurementData);

        return redirect()->route('clients.show', $client)->with('status', 'Client ajouté.');
    }

    public function show(Client $client): View
    {
        $client->load([
            'measurement',
            'commandes' => fn ($query) => $query->latest(),
            'paiements' => fn ($query) => $query->latest(),
        ]);

        return view('clients.show', compact('client'));
    }

    public function edit(Client $client): View
    {
        $client->load('measurement');

        return view('clients.form', [
            'client' => $client,
            'measurement' => $client->measurement ?? new ClientMeasurement(['mesure_at' => now()]),
        ]);
    }

    public function update(Request $request, Client $client): RedirectResponse
    {
        [$clientData, $measurementData] = $this->validated($request);

        $client->update($clientData);
        $this->saveMeasurement($client, $measurementData);

        return redirect()->route('clients.show', $client)->with('status', 'Client mis à jour.');
    }

    public function destroy(Client $client): RedirectResponse
    {
        $client->delete();

        return redirect()->route('clients.index')->with('status', 'Client supprimé.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'telephone' => ['nullable', 'string', 'max:50'],
            'whatsapp' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'date_naissance' => ['nullable', 'date'],
            'genre' => ['nullable', 'string', 'max:50'],
            'adresse' => ['nullable', 'string', 'max:255'],
            'profession' => ['nullable', 'string', 'max:255'],
            'source' => ['nullable', 'string', 'max:255'],
            'taille_habit' => ['nullable', 'string', 'max:50'],
            'morphologie' => ['nullable', 'string', 'max:100'],
            'preferences_style' => ['nullable', 'string'],
            'couleurs_favorites' => ['nullable', 'string'],
            'tissus_preferes' => ['nullable', 'string'],
            'allergies_tissus' => ['nullable', 'string'],
            'instructions_livraison' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
            'solde' => ['nullable', 'numeric', 'min:0'],
            'rappel_at' => ['nullable', 'date'],
            'measurement.tour_cou' => ['nullable', 'numeric', 'min:0'],
            'measurement.tour_poitrine' => ['nullable', 'numeric', 'min:0'],
            'measurement.tour_taille' => ['nullable', 'numeric', 'min:0'],
            'measurement.tour_hanches' => ['nullable', 'numeric', 'min:0'],
            'measurement.epaule' => ['nullable', 'numeric', 'min:0'],
            'measurement.carrure_dos' => ['nullable', 'numeric', 'min:0'],
            'measurement.longueur_buste' => ['nullable', 'numeric', 'min:0'],
            'measurement.longueur_robe' => ['nullable', 'numeric', 'min:0'],
            'measurement.longueur_jupe' => ['nullable', 'numeric', 'min:0'],
            'measurement.longueur_boubou' => ['nullable', 'numeric', 'min:0'],
            'measurement.longueur_pantalon' => ['nullable', 'numeric', 'min:0'],
            'measurement.entrejambe' => ['nullable', 'numeric', 'min:0'],
            'measurement.longueur_manche' => ['nullable', 'numeric', 'min:0'],
            'measurement.tour_bras' => ['nullable', 'numeric', 'min:0'],
            'measurement.tour_emmanchure' => ['nullable', 'numeric', 'min:0'],
            'measurement.tour_poignet' => ['nullable', 'numeric', 'min:0'],
            'measurement.tour_cuisse' => ['nullable', 'numeric', 'min:0'],
            'measurement.tour_genou' => ['nullable', 'numeric', 'min:0'],
            'measurement.tour_cheville' => ['nullable', 'numeric', 'min:0'],
            'measurement.hauteur_talon' => ['nullable', 'numeric', 'min:0'],
            'measurement.mesure_at' => ['nullable', 'date'],
            'measurement.prise_par' => ['nullable', 'string', 'max:255'],
            'measurement.notes' => ['nullable', 'string'],
        ]);

        $measurement = $data['measurement'] ?? [];
        unset($data['measurement']);

        return [$data, $measurement];
    }

    private function saveMeasurement(Client $client, array $measurementData): void
    {
        $hasMeasurement = collect($measurementData)
            ->filter(fn ($value) => filled($value))
            ->isNotEmpty();

        if (! $hasMeasurement) {
            return;
        }

        $client->measurement()->updateOrCreate([], $measurementData);
    }
}
