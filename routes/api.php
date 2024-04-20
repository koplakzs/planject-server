<?php

use App\Http\Controllers\api\DashboardController;
use App\Http\Controllers\api\pm\DashboardController as PmDashboardController;
use App\Http\Controllers\api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::controller(UserController::class)->group(function () {
    Route::get("/a", "redirect")->name("login");
    Route::post("/auth", "index");
    Route::post("/auth/register", "register");
    Route::get("/logout", "logout");
});


Route::middleware("auth:sanctum")->group(function () {
    Route::middleware("pt")->group(function () {
        Route::controller(DashboardController::class)->group(function () {
            Route::get("/dashboard", "index");
        });
    });
    Route::middleware("pm")->prefix("pm")->group(function () {
        Route::controller(PmDashboardController::class)->group(function () {
            Route::get("/dashboard", "index");
        });
    });
});
