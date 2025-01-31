<?php

use App\Http\Controllers\AuthController;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;


Route::get('/login', [AuthController::class, 'login'])->name('login');

Route::controller(AuthController::class)->group(function (Router $router) {
    $router->get('/', 'index')->middleware('verify.shopify')->name('home');
    $router->get('/{any}', 'index')->middleware('verify.shopify')->where('any', '(.+)?');
});
