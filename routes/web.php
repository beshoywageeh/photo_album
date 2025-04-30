<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlbumController;

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
Route::middleware('auth')->group(function () {
    Route::get('/albums', [AlbumController::class, 'index'])->name('album.index');
    Route::get('/album/create', [AlbumController::class, 'create'])->name('album.create');
    Route::post('/album/store', [AlbumController::class, 'store'])->name('album.store');
    Route::get('/album/edit/{id}', [AlbumController::class, 'edit'])->name('album.edit');
    Route::post('/album/update/{id}', [AlbumController::class, 'update'])->name('album.update');
    Route::post('/album/delete', [AlbumController::class, 'destroy'])->name('album.destroy');
    Route::post('/album/delete_transfer', [AlbumController::class, 'destroy_transfer'])->name('album.destroy_transfer');
});

require __DIR__.'/auth.php';