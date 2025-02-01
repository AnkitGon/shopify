<?php

use App\Http\Controllers\LoyaltyProgramController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/loyalty-settings', [LoyaltyProgramController::class, 'index']);
Route::post('/loyalty-settings', [LoyaltyProgramController::class, 'save']);



