<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StaffController extends Controller
{
    public function index(): View
    {
        return view('staff.index', [
            'staff' => Staff::orderBy('role')->orderBy('nom')->paginate(12),
        ]);
    }

    public function create(): View
    {
        return view('staff.form', ['member' => new Staff()]);
    }

    public function store(Request $request): RedirectResponse
    {
        Staff::create($this->validated($request));

        return redirect()->route('staff.index')->with('status', 'Membre ajouté.');
    }

    public function edit(Staff $staff): View
    {
        return view('staff.form', ['member' => $staff]);
    }

    public function update(Request $request, Staff $staff): RedirectResponse
    {
        $staff->update($this->validated($request));

        return redirect()->route('staff.index')->with('status', 'Membre mis à jour.');
    }

    public function destroy(Staff $staff): RedirectResponse
    {
        $staff->delete();

        return redirect()->route('staff.index')->with('status', 'Membre supprimé.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'role' => ['required', 'string', 'max:100'],
            'telephone' => ['nullable', 'string', 'max:50'],
            'tarif' => ['nullable', 'numeric', 'min:0'],
            'statut' => ['required', 'string', 'max:50'],
            'notes' => ['nullable', 'string'],
        ]);
    }
}
