<?php

use App\Actions\GetLevelCategoryLevelCountAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API;
Route::apiResource("menus",API\MenuController::class);
Route::apiResource("categories",API\CategoryController::class);
Route::apiResource("items",API\ItemController::class);
Route::put("items/discount/{item}",[API\ItemController::class,'discount']);
Route::put("categories/discount/{category}",[API\CategoryController::class,'discount']);
Route::put("menus/discount/{menu}",[API\MenuController::class,'discount']);
