<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::resource('books', BookController::class);
Route::post('books/search', [BookController::class, 'search']);
Route::post('books/checkout', [BookController::class, 'checkout']);
Route::put('books/{id}/returned', [BookController::class, 'returned']);
Route::put('books/{book}/{client}/borrowed', [BookController::class, 'borrowed']);

Route::resource('clients', ClientController::class);
Route::post('clients/search', [ClientController::class, 'search']);
Route::post('clients/checkout', [ClientController::class, 'checkout']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';
