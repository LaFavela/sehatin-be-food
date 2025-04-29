<?php

use App\Http\Controllers\FoodController;
use Illuminate\Support\Facades\Route;

Route::apiResource("/foods", FoodController::class);
