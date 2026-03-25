<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermintaanController;
use App\Http\Controllers\MesinController;
use App\Http\Controllers\PartListController;
use App\Http\Controllers\ProsesMfgController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\PlanningController; // ✅ TAMBAHKAN INI

// Authentication Routes
Route::get('/login',[LoginController::class,'showLogin'])->name('login');
Route::post('/login',[LoginController::class,'login'])->name('login.process');
Route::get('/logout',[LoginController::class,'logout'])->name('logout');

// Redirect based on role
Route::get('/', function () {
    if (!auth()->check()) {
        return redirect('/login');
    }

    $user = auth()->user();
    switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'engineer':
                return redirect()->route('engineer.dashboard');
            case 'operator':
                return redirect()->route('operator.dashboard');
            default:
                return redirect('/login');
        }
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');
    
    // Mesin Management
    Route::resource('mesin', MesinController::class);
    Route::post('mesin/{mesin}/status', [MesinController::class, 'updateStatus'])->name('mesin.status');
    
    // Permintaan Management
    Route::resource('permintaan', PermintaanController::class);
    Route::post('permintaan/{permintaan}/approve', [PermintaanController::class, 'approve'])->name('permintaan.approve');
    Route::post('permintaan/{permintaan}/reject', [PermintaanController::class, 'reject'])->name('permintaan.reject');
    
    // Part List Management
    Route::resource('part-list', PartListController::class);
    Route::post('part-list/{partList}/assign', [PartListController::class, 'assignDesigner'])->name('part-list.assign');
    Route::post('part-list/{partList}/status', [PartListController::class, 'updatePartStatus'])->name('part-list.status');

    // ✅ Production Planning Routes
    Route::get('planning', [PlanningController::class, 'index'])->name('planning.index');
    Route::post('planning', [PlanningController::class, 'store'])->name('planning.store');
    Route::get('planning/{id}', [PlanningController::class, 'show'])->name('planning.show');
    Route::put('planning/{id}', [PlanningController::class, 'update'])->name('planning.update');
    Route::delete('planning/{id}', [PlanningController::class, 'destroy'])->name('planning.destroy');

    // Schedule Overview
    Route::get('schedule', [ScheduleController::class, 'index'])->name('schedule.index');
});

// Design Routes
Route::middleware(['auth', 'role:engineer'])->prefix('engineer')->name('engineer.')->group(function () {

    Route::get('/dashboard', function () {
        return view('engineer.dashboard');
    })->name('dashboard');

    Route::get('/request', function () {
        return view('engineer.request');
    })->name('request');

    Route::get('/master', function () {
        return view('engineer.master');
    })->name('master');

    // Part List Management for Design
    Route::get('parts', [PartListController::class, 'index'])->name('parts.index');
    Route::get('parts/{partList}/edit', [PartListController::class, 'edit'])->name('parts.edit');
    Route::put('parts/{partList}', [PartListController::class, 'update'])->name('parts.update');
    Route::get('parts/{partList}', [PartListController::class, 'show'])->name('parts.show');
    
    // Accept part assignment
    Route::post('parts/{partList}/accept', function($partList) {
        $part = \App\Models\PartList::find($partList);
        if ($part->designer_id === auth()->id()) {
            $part->update(['status_part' => 'belum_dibeli']);
            return back()->with('success', 'Part berhasil diterima.');
        }
        return back()->with('error', 'Anda tidak berhak mengakses part ini.');
    })->name('parts.accept');

}); // <-- end engineer group

// Machining Routes
Route::middleware(['auth', 'role:operator'])->prefix('operator')->name('operator.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'operator'])->name('dashboard');
    
    // Schedule Management
    Route::get('schedule', [ScheduleController::class, 'index'])->name('schedule.index');
    Route::get('schedule/create/{partlist_id?}', [ScheduleController::class, 'create'])->name('schedule.create');
    Route::post('schedule', [ScheduleController::class, 'store'])->name('schedule.store');
    Route::post('schedule/{schedule}/start', [ScheduleController::class, 'startSchedule'])->name('schedule.start');
    Route::post('schedule/{schedule}/complete', [ScheduleController::class, 'completeSchedule'])->name('schedule.complete');
    
    // View parts ready for machining
    Route::get('parts', function() {
        $parts = \App\Models\PartList::where('status_part', 'ready')
            ->with('permintaan')
            ->get();
        return view('machining.parts', compact('parts'));
    })->name('parts');
});

// Common Routes (accessible by all authenticated users)
Route::middleware('auth')->group(function () {
    Route::get('/profile', function () {
        return view('profile.profile');
    })->name('profile');
    
    Route::put('/profile/update', function (\Illuminate\Http\Request $request) {
        $user = auth()->user();
        $user->update($request->only('nama', 'email'));
        
        if ($request->password) {
            $user->update(['password_hash' => \Illuminate\Support\Facades\Hash::make($request->password)]);
        }
        
        return back()->with('success', 'Profile berhasil diperbarui.');
    })->name('profile.update');
});