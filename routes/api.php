<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ContactController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('skills', SkillController::class);
Route::resource('projects', ProjectController::class);
Route::resource('services', ServiceController::class);
Route::resource('contacts', ContactController::class);
