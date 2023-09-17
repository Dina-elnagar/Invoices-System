<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\ProductController;
use \App\Http\Controllers\InvoiceDetailController;
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
    return view('auth.login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::resource('invoices', InvoiceController::class);
Route::resource('sections',SectionController::class);
Route::resource('products',ProductController::class);
Route::get('/section/{id}',[InvoiceController::class,'getproducts']);
Route::get('/InvoicesDetails/{id}',[InvoiceDetailController::class,'edit']);
Route::get('/view_file/{invoice_number}/{file_name}',[InvoiceDetailController::class,'open_file']);
Route::get('/download/{invoice_number}/{file_name}',[InvoiceDetailController::class,'get_file']);
Route::post('/delete_file',[InvoiceDetailController::class,'destroy'])->name('delete_file');
Route::resource('InvoiceAttachments',InvoiceDetailController::class);
Route::get('/edit_invoice/{id}',[InvoiceController::class,'edit']);



Route::get('/{page}', [AdminController::class, 'index']);