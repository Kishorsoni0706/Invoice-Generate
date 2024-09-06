<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoiceApiController;
use App\Http\Controllers\TokenController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});




Route::middleware('auth:sanctum')->post('/create-token', [TokenController::class, 'createToken']);

Route::middleware('auth:sanctum')->get('/invoices', [InvoiceApiController::class, 'index']);
