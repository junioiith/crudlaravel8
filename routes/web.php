<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PDFController;

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

Route::get('/pegawai', [EmployeeController::class, 'index'])->name('pegawai');

Route::get('/tambahpegawai', [EmployeeController::class, 'tambahpegawai'])->name('tambahpegawai');
Route::post('/insertpegawai', [EmployeeController::class, 'insertpegawai'])->name('insertpegawai');

Route::get('/editpegawai/{id}', [EmployeeController::class, 'editpegawai'])->name('editpegawai');
Route::post('/updatepegawai/{id}', [EmployeeController::class, 'updatepegawai'])->name('updatepegawai');

Route::get('/deletepegawai/{id}', [EmployeeController::class, 'deletepegawai'])->name('deletepegawai');

Route::get('/generate-pdf', [PDFController::class, 'generatePDF']);

//export pdf
Route::get('/exportpdf', [EmployeeController::class, 'exportpdf'])->name('exportpdf');

//export excel
Route::get('/exportexcel', [EmployeeController::class, 'exportexcel'])->name('exportexcel');

//import excel
Route::post('/importexcel', [EmployeeController::class, 'importexcel'])->name('importexcel');