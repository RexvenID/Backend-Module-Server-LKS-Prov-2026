<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register']);
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);



Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout']);

    Route::put('itineraries/{itinerary}/blocks/reorder', [\App\Http\Controllers\ItineraryBlockController::class, 'reorder']);

    Route::apiResource('itineraries', \App\Http\Controllers\ItineraryController::class);
    Route::apiResource('itineraries.blocks', \App\Http\Controllers\ItineraryBlockController::class)->except('update');

    Route::put('itineraries/{itinerary}/blocks/{itineraryBlock}/fields', [\App\Http\Controllers\BlockFieldValueController::class, 'store']);
    Route::apiResource('templates', \App\Http\Controllers\TemplateController::class);
});

Route::get('/images/{path}', [\App\Http\Controllers\ImageController::class, 'show'])->where('path', '.+');
