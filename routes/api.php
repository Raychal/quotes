<?php

use App\Http\Controllers\Api\QuoteController;
use Illuminate\Support\Facades\Route;

Route::controller(QuoteController::class)->group(function () {
    Route::get('quotes', 'index');
    Route::get('quote/{id}', 'show');
    Route::get('quote', 'random');
});
