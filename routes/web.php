<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\AuditController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\LeadController;

Route::get('/', function () {
    return Inertia::render('Leadpage');
})->name('home');

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::get('register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
});

Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('anunciar', [App\Http\Controllers\ImovelController::class, 'create'])->name('imovel.create');
    Route::post('anunciar', [App\Http\Controllers\ImovelController::class, 'store'])->name('imovel.store');
});

Route::post('imoveis/{imovel}/propostas', [App\Http\Controllers\LeadController::class, 'store'])->name('imoveis.propostas.store');

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('companies', CompanyController::class)->except(['show']);
    Route::resource('permissions', PermissionController::class)->only(['index', 'show']);
    Route::resource('audits', AuditController::class)->only(['index', 'show']);
    Route::resource('imoveis', \App\Http\Controllers\ImovelController::class)->parameters(['imoveis' => 'imovel'])->only(['index', 'show', 'edit', 'update', 'destroy']);
    Route::resource('leads', LeadController::class)->only(['index', 'show']);
    Route::put('leads/{lead}/unread', [LeadController::class, 'markAsUnread'])->name('leads.unread');

    Route::post('imoveis/{imovel}/contratos', [\App\Http\Controllers\Admin\ContratoController::class, 'store'])->name('imoveis.contratos.store');
    Route::delete('contratos/{contrato}', [\App\Http\Controllers\Admin\ContratoController::class, 'destroy'])->name('contratos.destroy');

    Route::post('contratos/{contrato}/pagamentos', [\App\Http\Controllers\Admin\PagamentoController::class, 'store'])->name('contratos.pagamentos.store');
    Route::delete('pagamentos/{pagamento}', [\App\Http\Controllers\Admin\PagamentoController::class, 'destroy'])->name('pagamentos.destroy');
});
