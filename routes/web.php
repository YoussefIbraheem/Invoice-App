<?php

use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SectionController;
use App\Models\InvoiceDetails;
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
    return view('index');
});
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/invoice_show',[InvoiceController::class,'index']);
    Route::get('/invoice_form',[InvoiceController::class,'showInvoiceForm']);
    Route::POST('/invoice_add',[InvoiceController::class,'store']);
    Route::get('/section_show',[SectionController::class,'index']);
    Route::POST('/section_add',[SectionController::class,'store']);
    Route::PUT('/section_update/{id}',[SectionController::class,'update']);
    Route::delete('/section_delete/{id}',[SectionController::class,'delete']);
    Route::get('/product_show',[ProductController::class,'index']);
    Route::POST('/product_add',[ProductController::class,'store']);
    Route::PUT('/product_update/{id}',[ProductController::class,'update']);
    Route::delete('/product_delete/{id}',[ProductController::class,'delete']);
    Route::get('/section/{id}', [InvoiceController::class,'getProducts']);
    Route::get('/Invoice_details',[InvoiceDetails::class,'index']);
});
