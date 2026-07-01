<?php

namespace App\Http\Controllers;

use App\Models\Modele;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ModeleController extends Controller
{
    public function index(): View
    {
        return view('modeles.index', [
            'modeles' => Modele::latest()->paginate(12),
        ]);
    }

    public function create(): View
    {
        return view('modeles.form', ['modele' => new Modele()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['photo_path'] = $this->storePhoto($request);

        Modele::create($data);

        return redirect()->route('modeles.index')->with('status', 'Modèle ajouté.');
    }

    public function edit(Modele $modele): View
    {
        return view('modeles.form', compact('modele'));
    }

    public function update(Request $request, Modele $modele): RedirectResponse
    {
        $data = $this->validated($request);

        if ($request->boolean('remove_photo')) {
            $this->deletePhoto($modele);
            $data['photo_path'] = null;
        }

        if ($request->hasFile('photo')) {
            $this->deletePhoto($modele);
            $data['photo_path'] = $this->storePhoto($request);
        }

        $modele->update($data);

        return redirect()->route('modeles.index')->with('status', 'Modèle mis à jour.');
    }

    public function destroy(Modele $modele): RedirectResponse
    {
        $this->deletePhoto($modele);
        $modele->delete();

        return redirect()->route('modeles.index')->with('status', 'Modèle supprimé.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'categorie' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'tissu_recommande' => ['nullable', 'string', 'max:255'],
            'prix_indicatif' => ['nullable', 'numeric', 'min:0'],
            'temps_estime_heures' => ['nullable', 'integer', 'min:0'],
            'niveau_difficulte' => ['required', 'string', 'max:50'],
            'favori' => ['nullable', 'boolean'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'remove_photo' => ['nullable', 'boolean'],
        ]) + ['favori' => $request->boolean('favori')];
    }

    private function storePhoto(Request $request): ?string
    {
        if (! $request->hasFile('photo')) {
            return null;
        }

        return $request->file('photo')->store('modeles', 'public');
    }

    private function deletePhoto(Modele $modele): void
    {
        if ($modele->photo_path) {
            Storage::disk('public')->delete($modele->photo_path);
        }
    }
}
