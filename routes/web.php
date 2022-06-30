<?php

use App\Http\Controllers\AreaPerubahanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanEvaluasiController;
use App\Http\Controllers\MasterUnitKerjaController;
use App\Http\Controllers\RencanaKerjaController;
use App\Http\Controllers\SubAreaPerubahanController;
use App\Http\Controllers\UnitKerjaController;
use App\Http\Controllers\UploadFileController;
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

Route::middleware(['checkauth'])->group(function(){
    Route::get('/', [DashboardController::class,'index'])->name('dashboard.index');
    Route::prefix('unit-kerja')->group(function(){
        Route::name('unitkerja.')->group(function(){
            Route::get('/',[UnitKerjaController::class,'index'])->name('index')->middleware('isadmin');
            Route::post('/',[UnitKerjaController::class,'store'])->name('store')->middleware('isadmin');
            Route::post('/delete',[UnitKerjaController::class,'delete'])->name('delete')->middleware('isadmin');
            Route::get('/create',[UnitKerjaController::class,'create'])->name('create')->middleware('isadmin');
            Route::get('/{id}',[UnitKerjaController::class,'edit'])->name('edit')->middleware('isadmin');
            Route::put('/{id}',[UnitKerjaController::class,'update'])->name('update')->middleware('isadmin');
        });
    });
    Route::prefix('master-unit-kerja')->group(function(){
        Route::name('masterunitkerja.')->group(function(){
            Route::get('/data',[MasterUnitKerjaController::class,'data'])->name('data')->middleware('isadmin');
            Route::get('/',[MasterUnitKerjaController::class,'index'])->name('index')->middleware('isadmin');
            Route::post('/',[MasterUnitKerjaController::class,'store'])->name('store')->middleware('isadmin');
            Route::post('/delete',[MasterUnitKerjaController::class,'delete'])->name('delete')->middleware('isadmin');
            Route::get('/create',[MasterUnitKerjaController::class,'create'])->name('create')->middleware('isadmin');
            Route::get('/{id}',[MasterUnitKerjaController::class,'edit'])->name('edit')->middleware('isadmin');
            Route::put('/{id}',[MasterUnitKerjaController::class,'update'])->name('update')->middleware('isadmin');
        });
    });
    Route::prefix('area-perubahan')->group(function(){
        Route::name('areaperubahan.')->group(function(){
            Route::get('/',[AreaPerubahanController::class,'index'])->name('index')->middleware(['iseksekutifandadmin']);            
            Route::post('/',[AreaPerubahanController::class,'store'])->name('store')->middleware(['iseksekutifandadmin']);            
            Route::post('/delete',[AreaPerubahanController::class,'delete'])->name('delete')->middleware(['iseksekutifandadmin']);            
            Route::get('/create',[AreaPerubahanController::class,'create'])->name('create')->middleware(['iseksekutifandadmin']);            
            Route::get('/edit/{id}',[AreaPerubahanController::class,'edit'])->name('edit')->middleware(['iseksekutifandadmin']);            
            Route::put('/update/{id}',[AreaPerubahanController::class,'update'])->name('update')->middleware(['iseksekutifandadmin']);            
        });        
    });
    Route::prefix('subarea-perubahan')->group(function(){
        Route::name('subareaperubahan.')->group(function(){
            Route::get('/',[SubAreaPerubahanController::class,'index'])->name('index')->middleware(['iseksekutifandadmin']);            
            Route::post('/',[SubAreaPerubahanController::class,'store'])->name('store')->middleware(['iseksekutifandadmin']);            
            Route::get('/create',[SubAreaPerubahanController::class,'create'])->name('create')->middleware(['iseksekutifandadmin']);            
            Route::get('/edit/{id}',[SubAreaPerubahanController::class,'edit'])->name('edit')->middleware(['iseksekutifandadmin']);            
            Route::put('/update/{id}',[SubAreaPerubahanController::class,'update'])->name('update')->middleware(['iseksekutifandadmin']);            
        });
    });
    Route::prefix('rencana-kerja')->group(function(){
        Route::name('rencanakerja.')->group(function(){
            Route::get('/',[RencanaKerjaController::class,'index'])->name('index')->middleware(['iseksekutifandadmin']);            
            Route::post('/',[RencanaKerjaController::class,'store'])->name('store')->middleware(['iseksekutifandadmin']);           
            Route::get('/edit/{id}',[RencanaKerjaController::class,'edit'])->name('edit')->middleware(['iseksekutifandadmin']);             
            Route::get('/create',[RencanaKerjaController::class,'create'])->name('create')->middleware(['iseksekutifandadmin']); 
            Route::put('/update/{id}',[RencanaKerjaController::class,'update'])->name('update')->middleware(['iseksekutifandadmin']);           
            Route::delete('/delete',[RencanaKerjaController::class,'delete'])->name('delete')->middleware(['iseksekutifandadmin']);           
        });
    });
    Route::prefix('lembar-kerja-evaluasi')->group(function(){
        Route::name('laporanevaluasi.')->group(function(){
            Route::get('/',[LaporanEvaluasiController::class,'index'])->name('index')->middleware(['iseksekutifandadmin']);            
            Route::post('/',[LaporanEvaluasiController::class,'store'])->name('store')->middleware(['iseksekutifandadmin']);            
            Route::post('/update',[LaporanEvaluasiController::class,'update'])->name('update')->middleware(['iseksekutifandadmin']);            
            Route::get('/berinilai/{id}/{fileid}',[LaporanEvaluasiController::class,'berinilai'])->name('berinilai')->middleware(['iseksekutifandadmin']);            
            Route::post('/delete',[LaporanEvaluasiController::class,'destroy'])->name('delete')->middleware(['iseksekutifandadmin']);            
            Route::get('/edit/{id}/{fileid}',[LaporanEvaluasiController::class,'edit'])->name('edit')->middleware(['iseksekutifandadmin']);            
            Route::get('/show/{id}/{fileid}',[LaporanEvaluasiController::class,'show'])->name('show')->middleware(['iseksekutifandadmin']);            
        });
    });

    Route::prefix('upload-file')->group(function(){
        Route::name('uploads.')->group(function(){
            Route::get('/',[UploadFileController::class,'index'])->name('index')->middleware(['isunitkerja']);            
            Route::post('/',[UploadFileController::class,'store'])->name('store')->middleware(['isunitkerja']);            
            Route::delete('/delete',[UploadFileController::class,'delete'])->name('delete')->middleware(['isunitkerja']);           
        });
    });
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
