<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\TagController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('quotes/{page?}', [QuoteController::class, 'index']);

Route::get('quote/{id}', [QuoteController::class, 'show']);

Route::post('quote', [QuoteController::class, 'create']);

Route::get('tags', [TagController::class, 'index']);