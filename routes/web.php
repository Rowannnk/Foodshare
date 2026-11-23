<?php

use App\Http\Controllers\Userzone\DashboardController;
use App\Http\Controllers\Userzone\ProfileController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicFoodListingController;
use App\Http\Controllers\PublicCategoryController;
use App\Http\Controllers\Userzone\ReservationController;
use App\Http\Controllers\Userzone\FoodListingController;

/*
 * Public Website routes
 */
Route::get('/', WelcomeController::class)->name('welcome');

// Todo: add your public routes here
Route::get('/food-listings', [PublicFoodListingController::class, 'index'])->name('food-listings.index');
Route::get('/food-listings/{foodListing}', [PublicFoodListingController::class, 'show'])->name('food-listings.show');
Route::get('/categories', [PublicCategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category:slug}', [PublicCategoryController::class, 'show'])->name('categories.show');

/*
 * Authentication routes
 */
require __DIR__.'/auth.php';


/*
 * Userzone routes
 */
Route::middleware('auth')->group(function () {
    // For the user's dashboard (after login)
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    // Todo: add your Userzone routes here
    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::post('/food-listings/{foodListing}/reservations', [ReservationController::class, 'store'])->name('reservations.store');
    Route::delete('/reservations/{reservation}', [ReservationController::class, 'destroy'])->name('reservations.destroy');
    Route::resource('my-listings', FoodListingController::class)
        ->parameters(['my-listings' => 'foodListing']);

    // For the user's profile management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
