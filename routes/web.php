<?php

use App\Http\Controllers\InvoiceAttachmentController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InvoiceDetailsController;
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
    Route::get('/invoice_show/{status}',[InvoiceController::class,'index']);
    Route::get('/invoice_form',[InvoiceController::class,'showInvoiceForm']);
    Route::POST('/invoice_add',[InvoiceController::class,'store']);
    Route::get('/invoice_details/{id}',[InvoiceDetailsController::class,'index']);
    Route::get('/invoice_update_form/{id}',[InvoiceController::class,'showInvoiceUpdateForm']);
    Route::post('/invoice_update/{id}',[InvoiceController::class,'update']);
    Route::delete('/invoice_delete/{id}',[InvoiceController::class,'delete']);
    Route::get('invoice_archived_show',[InvoiceController::class,'showArchivedInvoices']);
    Route::delete('/invoice_archived_delete/{id}',[InvoiceController::class,'deleteArchivedInvoices']);
    Route::put('/invoice_archived_restore/{id}',[InvoiceController::class,'restoreArchivedInvoices']);
    Route::get('/invoice_print/{id}',[InvoiceController::class,'printInvoice']);
    Route::get('/payment_form/{id}',[InvoiceController::class,'showPaymentForm']);
    Route::post('/add_payment/{id}',[InvoiceController::class,'changePaymentStatus']);
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
    Route::get('/get_file/{id}',[InvoiceAttachmentController::class,'getFile']);
    Route::get('/download_file/{id}',[InvoiceAttachmentController::class,'downloadFile']);
    Route::delete('/delete_file/{id}',[InvoiceAttachmentController::class,'deleteFile']);
    Route::post('invoice_attachment_add/{id}',[InvoiceAttachmentController::class,'store']);
});
