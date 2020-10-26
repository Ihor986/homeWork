<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\UserController;
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
// User
Route::get('user', [UserController::class, 'index']);
Route::get('user/{user}', [UserController::class, 'show']);
Route::put('user/{user}', [UserController::class, 'update']);
Route::delete('user/{user}', [UserController::class, 'destroy']);
// Organization
Route::apiResource('organization', OrganizationController::class);
// Vacancy
Route::apiResource('vacancy', VacancyController::class);
// Stats





// Authenticated users
Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::apiResource('users', UserController::class);
});

// Fallback route
Route::fallback([AuthController::class, 'fallback']);
