<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ItemController;
use Illuminate\Support\Facades\Route;

// Land on the items catalog automatically
Route::get('/', function () {
    return redirect('/items');
});

// 🌍 PUBLIC ACCESS: Anyone (Guests, Customers, Admins) can look at the catalog
Route::get('/items', [ItemController::class, 'index']);

// =========================================================================
// GROUP 1: ALL LOGGED-IN USERS (Customers, Staff, & Admins)
// =========================================================================
Route::middleware(['auth'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Must be logged in to process an actual rental order or see history
    Route::post('/items/{id}/rent', [ItemController::class, 'rent']);
    Route::get('/my-rentals', [ItemController::class, 'myRentals']);
    
    // ↩️ Customer requests a return
    Route::post('/rentals/{id}/request-return', [ItemController::class, 'requestReturn']);
});

// =========================================================================
// GROUP 2: STRICTLY ADMIN & STAFF VAULT (Allows both roles to view & process)
// =========================================================================
Route::group(['middleware' => ['auth']], function () {
    Route::group(['middleware' => [function ($request, $next) {
        // Explicitly grant access if the logged-in user's role column is admin OR staff
        if (auth()->check() && (auth()->user()->role === 'admin' || auth()->user()->role === 'staff')) {
            return $next($request);
        }
        
        abort(403, 'Access Denied: Restricted to Administrator or Staff privileges.');
    }]], function () {

        // Master Inventory CRUD
        Route::get('/items/create', [ItemController::class, 'create']);
        Route::post('/items', [ItemController::class, 'store']);
        Route::get('/items/{id}/edit', [ItemController::class, 'edit']);
        Route::post('/items/{id}/update', [ItemController::class, 'update']);
        Route::post('/items/{id}/delete', [ItemController::class, 'destroy']);

        // Transaction Logs & Management (Both roles can view this layout now)
        Route::get('/rentals', [ItemController::class, 'rentals']);
        
        // 🛠️ The processing route acting as the "Approve Return" step
        Route::post('/rentals/{id}/return', [ItemController::class, 'returnItem']);
        
        // Transaction Log Manual Overrides
        Route::get('/rentals/{id}/edit', [ItemController::class, 'editRental']);
        Route::post('/rentals/{id}/update', [ItemController::class, 'updateRental']);

        // 👥 Master User CRUD & Role Routing Control
        Route::get('/users', [ItemController::class, 'manageUsers']);
        Route::post('/users/store', [ItemController::class, 'storeUser']);
        Route::post('/users/{id}/role', [ItemController::class, 'updateUserRole']);
    });
});

require __DIR__.'/auth.php';