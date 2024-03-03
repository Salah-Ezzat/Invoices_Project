<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Customers_ReportController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\InvoiceArcheiveController;
use App\Http\Controllers\InvoicesDetailsController;
use App\Http\Controllers\InvoiceAttachmentsController;
use App\Http\Controllers\Invoices_ReportController;

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
    return view('auth.login');
});


Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::resource('invoices', InvoiceController::class);

Route::resource('sections', SectionController::class);

Route::resource('products', ProductController::class);

Route::resource('InvoicesDetails', InvoicesDetailsController::class);

Route::resource('InvoiceAttachments', InvoiceAttachmentsController::class);

Route::resource('Archeive', InvoiceArcheiveController::class);

Route::get('/section/{id}', [InvoiceController::class,'getproducts']);

Route::get('download/{invoice_number}/{file_name}', [InvoicesDetailsController::class,'get_file']);

Route::get('View_file/{invoice_number}/{file_name}',[InvoicesDetailsController::class, 'open_file']);

Route::post('delete_file', [InvoicesDetailsController::class, 'destroy'])->name('delete_file');

Route::get('/edit_invoice/{id}', [InvoiceController::class, 'edit']);

Route::get('/Status_show/{id}', [InvoiceController::class,'show'])->name('Status_show');

Route::post('/Status_Update/{id}', [InvoiceController::class, 'Status_Update'])->name('Status_Update');

Route::get('Invoice_Paid',[InvoiceController::class, 'Invoice_Paid']);

Route::get('Invoice_UnPaid',[InvoiceController::class, 'Invoice_UnPaid']);

Route::get('Invoice_Partial',[InvoiceController::class, 'Invoice_Partial']);

Route::get('Print_invoice/{id}',[InvoiceController::class,'Print_invoice']);

Route::get('export_invoices', [InvoiceController::class,'export']);

Route::middleware('auth')->group(function () {
    // Our resource routes
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);

});
Route::get('invoices_report',[Invoices_ReportController::class,'index']);

Route::post('Search_invoices',[Invoices_ReportController::class,'Search_invoices']);

Route::get('customers_report',[Customers_ReportController::class,'index']);

Route::post('Search_customers',[Customers_ReportController::class,'Search_customers']);

Route::get('MarkAsRead_all',[InvoiceController::class, 'MarkAsRead_all'])->name('MarkAsRead_all');

Route::get('unreadNotifications_count', [InvoiceController::class,'unreadNotifications_count'])->name('unreadNotifications_count');

Route::get('unreadNotifications',[InvoiceController::class,'unreadNotifications'])->name('unreadNotifications');












Route::get('/{page}', [AdminController::class, 'index']);
