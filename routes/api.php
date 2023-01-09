<?php

use App\Http\Controllers\AdminController;
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

Route::controller(MediumController::class)->group(function () {
    Route::get('media/{id}', 'show');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
