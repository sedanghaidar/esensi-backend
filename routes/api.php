<?php

use App\Http\Controllers\Api\ActivityController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ParticipantController;
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

Route::post('login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {

    Route::prefix('kegiatan')->group(function () {
        Route::get('/', [ActivityController::class, 'index']);                  //list data
        Route::get('/{id}', [ActivityController::class, 'show']);               //detail data
        Route::post('/', [ActivityController::class, 'store']);                 //insert data
        Route::post('/{id}', [ActivityController::class, 'update']);            //update data
        Route::post('/delete/{id}', [ActivityController::class, 'destroy']);    //method Delete gatau knp ga bisa di gunain, akhir nya pakai post
    });

    Route::prefix('peserta')->group(function () {
        Route::get('/kegiatan/{id}', [ParticipantController::class, 'getParticipantByKegiatanID']);               //detail data

        Route::get('/', [ParticipantController::class, 'index']);                  //list data
        Route::get('/{id}', [ParticipantController::class, 'show']);               //detail data
        Route::post('/', [ParticipantController::class, 'store']);                 //insert data
        Route::post('/{id}', [ParticipantController::class, 'update']);            //update data
        Route::post('/delete/{id}', [ParticipantController::class, 'destroy']);    //method Delete gatau knp ga bisa di gunain, akhir nya pakai post
    });
});
