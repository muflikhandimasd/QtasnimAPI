<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataPenjualanController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/add-data', [DataPenjualanController::class, 'createData']);
Route::put('/edit-data/{id}', [DataPenjualanController::class, 'editData']);
Route::get('/get-data/{id}', [DataPenjualanController::class, 'getData']);
Route::get('/get-all-data', [DataPenjualanController::class, 'getAllData']);
Route::get('/search-data', [DataPenjualanController::class, 'searchData']);
Route::delete('/delete-data/{id}', [DataPenjualanController::class, 'deleteData']);
