<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BoxController;
use App\Http\Controllers\ArsipController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes([
    'register' => false,
]);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('box', BoxController::class);
Route::resource('berkas', ArsipController::class);
Route::get('/export', [ArsipController::class, 'exportIndex'])->name('exportIndex');
Route::post('/exportdata', [ArsipController::class, 'exportFilter'])->name('exportFilter');

Route::get('admin', [AdminController::class, 'index'])->name('admin.index');
Route::get('admin/create', [AdminController::class, 'create'])->name('admin.create');
Route::post('admin/store', [AdminController::class, 'store'])->name('admin.store');
Route::put('admin/{adm}', [AdminController::class, 'update'])->name('admin.update');
Route::delete('admin/{adm}/delete', [AdminController::class, 'destroy'])->name('admin.delete');
Route::get('admin/{adm}/edit', [AdminController::class, 'edit'])->name('admin.edit');

// AJAX Request
Route::get('/databox', [BoxController::class, 'Databox'])->name('databox');
Route::get('/databoxdetail/{id}', [BoxController::class, 'DataboxDetail'])->name('databoxDetail');
Route::get('/databerkas', [ArsipController::class, 'Databerkas'])->name('databerkas');
