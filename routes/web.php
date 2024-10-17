<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CommunicationsController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\TenantsController;
use App\Http\Controllers\UnitsController;
use App\Http\Controllers\UtilitiesController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [AuthenticatedSessionController::class, 'create'])
    ->name('login')->middleware('guest');
Route::post('login', [AuthenticatedSessionController::class, 'store'])
    ->name('login.post')->middleware('guest');




Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');





Route::middleware('auth')->group(function () {

    Route::get('properties', [PropertyController::class, 'index'])->name('properties.index');
    Route::post('properties', [PropertyController::class, 'store'])->name('properties.store');
    Route::get('properties/create', [PropertyController::class, 'create'])->name('properties.create');
    Route::get('properties/edit/{property}', [PropertyController::class, 'edit'])->name('properties.edit');
    Route::put('properties/{property}', [PropertyController::class, 'update'])->name('properties.update');
    Route::delete('properties/{property}', [PropertyController::class, 'destroy'])->name('properties.destroy');

    Route::get('units', [UnitsController::class, 'index'])->name('units.index');
    Route::get('/units/create', [UnitsController::class, 'create'])->name('units.create');
    Route::get('units/edit/{unit}', [UnitsController::class, 'edit'])->name('units.edit');
    Route::post('units', [UnitsController::class, 'store'])->name('units.store');
    Route::get('units/{property}', [UnitsController::class, 'show'])->name('units.store');

    Route::resource('utilities', UtilitiesController::class);

    Route::get('tenants', [TenantsController::class, 'index'])->name('tenants.index');
    Route::get('tenants/create', [TenantsController::class, 'create'])->name('tenants.create');

    Route::get('invoices', [InvoicesController::class, 'index'])->name('invoices.index');

    Route::get('payments', [PaymentsController::class, 'index'])->name('payments.index');


    Route::get('communication', [CommunicationsController::class, 'index'])->name('communication.index');
    Route::get('communication/create', [CommunicationsController::class, 'create'])->name('communication.create');
    Route::post('communication/single', [CommunicationsController::class, 'single'])->name('communication.single');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});







require __DIR__.'/auth.php';
