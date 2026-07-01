<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepenseController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\ModeleController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', DashboardController::class)->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::resource('clients', ClientController::class);
    Route::resource('commandes', CommandeController::class);
    Route::resource('modeles', ModeleController::class)->except(['show']);
    Route::get('factures/{facture}/pdf', [FactureController::class, 'pdf'])->name('factures.pdf');
    Route::get('factures/{facture}/print', [FactureController::class, 'print'])->name('factures.print');
    Route::resource('factures', FactureController::class)->except(['show']);
    Route::get('paiements/{paiement}/pdf', [PaiementController::class, 'pdf'])->name('paiements.pdf');
    Route::get('paiements/{paiement}/print', [PaiementController::class, 'print'])->name('paiements.print');
    Route::resource('paiements', PaiementController::class)->except(['show']);
    Route::resource('depenses', DepenseController::class)->except(['show']);
    Route::resource('stocks', StockController::class)->except(['show']);
    Route::resource('staff', StaffController::class)->except(['show']);
    Route::resource('users', UserController::class)->except(['show']);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
