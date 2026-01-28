<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermintaanController;
use App\Http\Controllers\PartListController;
use App\Http\Controllers\MesinController;
use App\Http\Controllers\ProsesMfgController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ReportController;

// Authentication Routes (from laravel/ui)
Auth::routes();

// Redirect root to appropriate dashboard based on role
Route::get('/', function () {
    $user = auth()->user();
    
    if (!$user) {
        return redirect('/login');
    }
    
    switch ($user->role) {
        case 'admin':
        case 'engineer':
            return redirect()->route('dashboard');
        case 'operator':
            return redirect()->route('operator.dashboard');
        case 'requester':
            return redirect()->route('requester.dashboard');
        default:
            return redirect('/login');
    }
});

// Admin & Engineer Routes
Route::middleware(['auth', 'role:admin,engineer'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Resource Controllers
    Route::resource('permintaan', PermintaanController::class);
    Route::resource('part-list', PartListController::class);
    Route::resource('mesin', MesinController::class);
    Route::resource('proses-mfg', ProsesMfgController::class);
    Route::resource('schedule', ScheduleController::class);
    
    // Additional Routes
    Route::post('/permintaan/{id}/approve', [PermintaanController::class, 'approve'])->name('permintaan.approve');
    Route::post('/permintaan/{id}/reject', [PermintaanController::class, 'reject'])->name('permintaan.reject');
    Route::get('/permintaan/{id}/parts', [PermintaanController::class, 'parts'])->name('permintaan.parts');
    
    // Report Routes
    Route::get('/reports', [ReportController::class, 'index'])->name('report.index');
    Route::get('/reports/production', [ReportController::class, 'production'])->name('report.production');
    Route::get('/reports/machine-utilization', [ReportController::class, 'machineUtilization'])->name('report.machine-utilization');
    Route::get('/reports/export/excel', [ReportController::class, 'exportExcel'])->name('report.export.excel');
    Route::get('/reports/export/pdf', [ReportController::class, 'exportPdf'])->name('report.export.pdf');
});

// Operator Routes
Route::middleware(['auth', 'role:operator'])->prefix('operator')->name('operator.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboardOperator'])->name('dashboard');
    Route::get('/tugas', [ScheduleController::class, 'tugasOperator'])->name('tugas');
    Route::get('/proses', [ProsesMfgController::class, 'prosesOperator'])->name('proses');
    
    Route::post('/proses/{id}/start', [ProsesMfgController::class, 'startProses'])->name('proses.start');
    Route::post('/proses/{id}/complete', [ProsesMfgController::class, 'completeProses'])->name('proses.complete');
    Route::post('/proses/{id}/update-quantity', [ProsesMfgController::class, 'updateQuantity'])->name('proses.update-quantity');
});

// Requester Routes
Route::middleware(['auth', 'role:requester'])->prefix('requester')->name('requester.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::get('/permintaan/create', [PermintaanController::class, 'createRequester'])->name('permintaan.create');
    Route::post('/permintaan', [PermintaanController::class, 'storeRequester'])->name('permintaan.store');
    Route::get('/permintaan/{id}', [PermintaanController::class, 'showRequester'])->name('permintaan.show');
    Route::get('/status', [PermintaanController::class, 'statusRequester'])->name('status');
});

// Profile Route (all authenticated users)
Route::middleware('auth')->get('/profile', function () {
    return view('profile');
})->name('profile');

// API Routes for mobile/other systems
Route::prefix('api')->middleware('auth:sanctum')->group(function () {
    Route::get('/permintaan', [PermintaanController::class, 'apiIndex']);
    Route::get('/mesin/status', [MesinController::class, 'apiStatus']);
    Route::post('/proses/update', [ProsesMfgController::class, 'apiUpdate']);
});