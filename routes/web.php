<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Kematian2016Controller;
use App\Http\Controllers\Kematian2017Controller;
use App\Http\Controllers\Kematian2018Controller;
use App\Http\Controllers\Kematian2019Controller;
use App\Http\Controllers\Kematian2020Controller;
use App\Http\Controllers\KotaBogorController;

// Route::get('/', function () {
//     return view('kotabogor');
// });

Route::get('/', [KotaBogorController::class, 'index'])->name('get_kotabogor');
Route::get('/kematian_2016', [Kematian2016Controller::class, 'index'])->name('get_kematian2016');
Route::get('/kematian_2017', [Kematian2017Controller::class, 'index'])->name('get_kematian2017');
Route::get('/kematian_2018', [Kematian2018Controller::class, 'index'])->name('get_kematian2018');
Route::get('/kematian_2019', [Kematian2019Controller::class, 'index'])->name('get_kematian2019');
Route::get('/kematian_2020', [Kematian2020Controller::class, 'index'])->name('get_kematian2020');