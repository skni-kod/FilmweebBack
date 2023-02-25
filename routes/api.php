<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MediumController;
use App\Models\Medium;
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

Route::post('actors/{id}/addImage', [AdminController::class, 'addImage']);
Route::get('person/{id}', [AdminController::class, 'getPerson']);

Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::get('/login/{provider}/redirect', 'redirectToProvider');
    Route::get('/login/{provider}/callback', 'handleProviderCallback');
});
Route::controller(MediumController::class)->group(function () {
    Route::get('media', 'index');
    Route::get('media/top', 'getTopRated');
    Route::get('media/{id}', 'show');
    Route::get('media/{id}/casts', 'getCasts');
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
