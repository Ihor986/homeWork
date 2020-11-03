<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VacancyBookController;
use App\Http\Controllers\VacancyController;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


//Auth
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// Authenticated users
Route::group(['middleware' => ['auth:sanctum']], function () {
    // User

    // Route::get('user', [UserController::class, 'index']);
    // Route::post('user', [UserController::class, 'store']);
    // Route::get('user/{id}', [UserController::class, 'show']);
    // Route::put('user/{id}', [UserController::class, 'update']);
    // Route::delete('user/{id}', [UserController::class, 'destroy']);
    Route::apiResource('user', UserController::class);
    // Organization
    Route::apiResource('organization', OrganizationController::class);
    // Vacancy
    Route::apiResource('vacancy', VacancyController::class);
    Route::post('vacancy-book', [VacancyController::class, 'book']);
    Route::post('vacancy-unbook', [VacancyController::class, 'unBook']);
});
// Stats
Route::group(['prefix' => 'stats'], function () {
    Route::get('vacancy', [VacancyController::class, 'statsVacancy'])->middleware('auth:sanctum');
    Route::get('organization', [OrganizationController::class, 'statsOrganization'])->middleware('auth:sanctum');
    Route::get('user', [UserController::class, 'statsUser'])->middleware('auth:sanctum');
});

// Fallback route
Route::fallback([AuthController::class, 'fallback']);
