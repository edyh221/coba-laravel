<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PeopleController;
use App\Http\Controllers\UserController;
use App\Models\People;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->middleware(['auth'])->group(function() {
  Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
  Route::get('/people', [PeopleController::class, 'index'])->name('people.index');
  Route::delete('/people/{id}', [PeopleController::class, 'destroy'])
  ->middleware('can:isAdmin')
  ->name('people.destroy');
  Route::get('/people/create', [PeopleController::class, 'create'])->name('people.create');
  Route::post('/people', [PeopleController::class, 'store'])->name('people.store');
  Route::get('/people/{id}/edit', [PeopleController::class, 'edit'])->name('people.edit');
  Route::put('/people', [PeopleController::class, 'update'])->name('people.update');
  Route::get('/people/csv', [PeopleController::class, 'csv'])->name('people.csv');
  Route::get('/people/csv-with-chunk', [PeopleController::class, 'csvWithChunking'])->name('people.csv-chunk');

  Route::middleware('can:isAdmin')->group(function() {
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');
  });
});

require __DIR__.'/auth.php';
