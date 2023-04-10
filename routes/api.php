<?php

use App\Http\Controllers\Api\ActivityController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\OrganizationController;
use App\Http\Controllers\Api\ParticipantController;
use App\Http\Controllers\Api\OrganizationLimitController;
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

Route::get('/kegiatan/kode/{codeurl}', [ActivityController::class, 'loadByCode']);  //detail kegiatan by kode url (public)
Route::post('/peserta/daftar', [ParticipantController::class, 'store']);
Route::get('/organisasi', [OrganizationController::class, 'index']);                  //list data
Route::get('/organisasi/kegiatan/{id}', [OrganizationController::class, 'listByKegiatan']);                  //list data

// Route::post('/organization-limit', [OrganizationLimitController::class, 'store']);
Route::get('/peserta/{id}', [ParticipantController::class, 'show']);               //detail data

Route::get('/peserta/download/excel', [ParticipantController::class, 'downloadExcel']);
Route::get('/peserta/download/pdf', [ParticipantController::class, 'downloadPDF']);

Route::get('/peserta/blast-wa/{id}', [ParticipantController::class, 'sendWAPerActivity']);
Route::middleware(['auth:sanctum'])->group(function () {

    Route::prefix('organisasi')->group(function () {
        Route::post('/tambah', [OrganizationController::class, 'store']);
        Route::post('/hapus/{id}', [OrganizationController::class, 'destroy']);
        Route::post('/update/{id}', [OrganizationController::class, 'update']);
    });

    Route::prefix('kegiatan')->group(function () {
        Route::get('/', [ActivityController::class, 'index']);                  //list data
        Route::get('/{id}', [ActivityController::class, 'show']);               //detail data
        Route::post('/', [ActivityController::class, 'store']);                 //insert data
        Route::post('/{id}', [ActivityController::class, 'update']);            //update data
        Route::post('/delete/{id}', [ActivityController::class, 'destroy']);    //method Delete gatau knp ga bisa di gunain, akhir nya pakai post

        Route::post('/notulensi/{id}', [ActivityController::class, 'updateLaporan']);            //update data
    });

    Route::prefix('peserta')->group(function () {
        Route::get('/kegiatan/{id}', [ParticipantController::class, 'getParticipantByKegiatanID']);               //detail data
        Route::post('/scan', [ParticipantController::class, 'scanQRParticipant']);

        Route::get('/', [ParticipantController::class, 'index']);                  //list data
        // Route::get('/{id}', [ParticipantController::class, 'show']);               //detail data
        // Route::post('/', [ParticipantController::class, 'store']);                 //insert data
        Route::post('/{id}', [ParticipantController::class, 'update']);            //update data
        Route::post('/delete/{id}', [ParticipantController::class, 'destroy']);    //method Delete gatau knp ga bisa di gunain, akhir nya pakai post
    });

    Route::prefix('organization-limit')->group(function () {
        Route::get('/byactid/{kegiatan_id}', [OrganizationLimitController::class, 'getListLimitOrgbyActivityID']);                  //list data by Kegiatan ID
        Route::post('/insert', [OrganizationLimitController::class, 'bulkStore']);   //insert all data

        Route::get('/', [OrganizationLimitController::class, 'index']);                  //list data
        // Route::get('/{id}', [OrganizationLimitController::class, 'show']);               //detail data
        Route::post('/createupdate', [OrganizationLimitController::class, 'store']);      //insert data
        // Route::post('/{id}', [OrganizationLimitController::class, 'update']);            //update data
        Route::post('/delete/{id}', [OrganizationLimitController::class, 'destroy']);    //method Delete gatau knp ga bisa di gunain, akhir nya pakai post
    });
});
