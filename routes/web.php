<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::middleware("guest")->group(function () {
    Route::get("/login", [AuthController::class, "showLogin"])->name("login");
    Route::post("/login", [AuthController::class, "login"])->middleware(
        "throttle:5,1",
    );
    Route::get("/verificar", [AuthController::class, "showVerificar"])->name(
        "verificar",
    );
    Route::post("/verificar", [AuthController::class, "verificar"])->middleware(
        "throttle:5,1",
    );
});

Route::middleware("auth")->group(function () {
    Route::get("/", fn() => view("home"))->name("home");
    Route::post("/logout", [AuthController::class, "logout"])->name("logout");
});
