<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\NewController;

Route::prefix('v1')->group(function () {
    // Route::middleware('jwt.auth')->group(function () {
        Route::prefix('geo_tagging')->group(function () {
            Route::get('/',[NewController::class,'index']);
        });
    // });
});

