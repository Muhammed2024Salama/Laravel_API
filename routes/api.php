<?php

use App\Http\Controllers\Api\V1\CustomerController;
use App\Http\Controllers\Api\V1\InvoiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');

// apiResource ==>> resource in route 'web.php'

Route::group(['prefix' => 'v1', 'middleware' => ['auth:sanctum']], function () {
    Route::apiResources([
        'customers' => CustomerController::class,
        'invoices' => InvoiceController::class,
    ]);

    Route::post('invoices/bulk', [InvoiceController::class, 'bulkstore']);
});
