<?php

use App\Http\Controllers\GroupController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReportEntryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // return view('welcome');
    return redirect()->route('groups.index');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route::get('/groups/{group}/detail/{name}', [GroupController::class, 'showMember'])->name('groups.show-member');
Route::get('/groups/{group}/edit-member/{whatsapp}', [GroupController::class, 'editMember'])->name('groups.edit-member');
Route::get('/groups/{group}/add-member', [GroupController::class, 'addMember'])->name('groups.add-member');
Route::post('/groups/store-member', [GroupController::class, 'storeMember'])->name('groups.store-member');
Route::delete('/groups/{group}/remove-member', [GroupController::class, 'removeMember'])->name('groups.remove-member');
Route::resource('groups', GroupController::class);
Route::get('/reports/create/{group}', [ReportController::class, 'create'])->name('reports.create');
Route::resource('reports', ReportController::class)->except(['create']);
Route::get('/laporan', [ReportEntryController::class, 'search'])->name('entries.search');
Route::post('/laporan', [ReportEntryController::class, 'find'])->name('entries.find');
Route::get('/laporan/detail/{name}', [ReportEntryController::class, 'show'])->name('entries.show');
Route::resource('{report}/entries', ReportEntryController::class)->except(['show']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
