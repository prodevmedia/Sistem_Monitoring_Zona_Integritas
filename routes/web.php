<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LembarKerjaEvaluasiController;
use App\Http\Controllers\MasterUnitKerjaController;
use App\Http\Controllers\PeriodeController;
use App\Http\Controllers\RencanaKerjaController;
use App\Http\Controllers\UploadRealisasiKerjaController;
use App\Http\Controllers\UserUnitKerjaController;
use Illuminate\Support\Facades\Auth;
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

Route::middleware(['checkauth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::prefix('periode')->group(function () {
        Route::name('periode.')->group(function () {
            Route::get('/', [PeriodeController::class, 'index'])->name('index')->middleware('isadmin');
            Route::post('/', [PeriodeController::class, 'store'])->name('store')->middleware('isadmin');
            Route::post('/delete', [PeriodeController::class, 'delete'])->name('delete')->middleware('isadmin');
            Route::get('/create', [PeriodeController::class, 'create'])->name('create')->middleware('isadmin');
            Route::get('/{id}', [PeriodeController::class, 'edit'])->name('edit')->middleware('isadmin');
            Route::put('/{id}', [PeriodeController::class, 'update'])->name('update')->middleware('isadmin');

            Route::post('/change', [PeriodeController::class, 'change'])->name('change')->middleware('isadmin');
            Route::post('/range', [PeriodeController::class, 'range'])->name('range')->middleware('isadmin');
            Route::post('/toggle-active', [PeriodeController::class, 'toggleActive'])->name('toggleActive')->middleware('isadmin');
        });
    });
    Route::prefix('user-unit-kerja')->group(function () {
        Route::name('userUnitKerja.')->group(function () {
            Route::get('/', [UserUnitKerjaController::class, 'index'])->name('index')->middleware('isadmin');
            Route::post('/', [UserUnitKerjaController::class, 'store'])->name('store')->middleware('isadmin');
            Route::post('/delete', [UserUnitKerjaController::class, 'delete'])->name('delete')->middleware('isadmin');
            Route::get('/create', [UserUnitKerjaController::class, 'create'])->name('create')->middleware('isadmin');
            Route::get('/{id}', [UserUnitKerjaController::class, 'edit'])->name('edit')->middleware('isadmin');
            Route::put('/{id}', [UserUnitKerjaController::class, 'update'])->name('update')->middleware('isadmin');
        });
    });
    Route::prefix('master-unit-kerja')->group(function () {
        Route::name('masterunitkerja.')->group(function () {
            Route::get('/data', [MasterUnitKerjaController::class, 'data'])->name('data')->middleware('isadmin');
            Route::get('/', [MasterUnitKerjaController::class, 'index'])->name('index')->middleware('isadmin');
            Route::post('/', [MasterUnitKerjaController::class, 'store'])->name('store')->middleware('isadmin');
            Route::post('/delete', [MasterUnitKerjaController::class, 'delete'])->name('delete')->middleware('isadmin');
            Route::get('/create', [MasterUnitKerjaController::class, 'create'])->name('create')->middleware('isadmin');
            Route::get('/{id}', [MasterUnitKerjaController::class, 'edit'])->name('edit')->middleware('isadmin');
            Route::put('/{id}', [MasterUnitKerjaController::class, 'update'])->name('update')->middleware('isadmin');

            Route::get('/{id}/getUserUnitKerja', [MasterUnitKerjaController::class, 'getUserUnitKerja'])->name('getUserUnitKerja')->middleware('isadmin');
        });
    });
    Route::prefix('rencana-kerja')->group(function () {
        Route::name('rencanakerja.')->group(function () {
            Route::get('/', [RencanaKerjaController::class, 'index'])->name('index')->middleware(['iseksekutifandadmin']);
            Route::post('/', [RencanaKerjaController::class, 'store'])->name('store')->middleware(['iseksekutifandadmin']);
            Route::get('/edit/{id}', [RencanaKerjaController::class, 'edit'])->name('edit')->middleware(['iseksekutifandadmin']);
            Route::get('/create', [RencanaKerjaController::class, 'create'])->name('create')->middleware(['iseksekutifandadmin']);
            Route::put('/update/{id}', [RencanaKerjaController::class, 'update'])->name('update')->middleware(['iseksekutifandadmin']);
            Route::post('/delete', [RencanaKerjaController::class, 'delete'])->name('delete')->middleware(['iseksekutifandadmin']);

            Route::post('/print', [RencanaKerjaController::class, 'print'])->name('print')->middleware(['iseksekutifandadmin']);
        });
    });
    Route::prefix('lembar-kerja-evaluasi')->group(function () {
        Route::name('lembarKerjaEvaluasi.')->group(function () {
            Route::get('/', [LembarKerjaEvaluasiController::class, 'index'])->name('index')->middleware(['iseksekutifandadmin']);
            Route::post('/evaluasi', [LembarKerjaEvaluasiController::class, 'evaluasi'])->name('evaluasi')->middleware(['iseksekutifandadmin']);
        });
    });

    Route::prefix('upload-file')->group(function () {
        Route::name('uploads.')->group(function () {
            Route::get('/', [UploadFileController::class, 'index'])->name('index')->middleware(['isunitkerja']);
            Route::post('/', [UploadFileController::class, 'store'])->name('store')->middleware(['isunitkerja']);
            Route::delete('/delete', [UploadFileController::class, 'delete'])->name('delete')->middleware(['isunitkerja']);
        });
    });

    Route::prefix('upload-realisasi-kerja')->group(function () {
        Route::name('uploadRealiasiKerja.')->group(function () {
            Route::get('/', [UploadRealisasiKerjaController::class, 'index'])->name('index')->middleware(['isunitkerja']);
            Route::post('/', [UploadRealisasiKerjaController::class, 'upload'])->name('upload')->middleware(['isunitkerja']);
            Route::delete('/delete', [UploadRealisasiKerjaController::class, 'delete'])->name('delete')->middleware(['isunitkerja']);
        });
    });
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//Task
Route::get('/kerja-unit', [UserUnitKerjaController::class, 'kerjaUnit_show']);
