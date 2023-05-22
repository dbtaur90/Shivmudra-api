<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AddressDirectoryController;
use App\Http\Controllers\API\SabhasadRegistrationController;
use App\Http\Controllers\API\LoginController;
use App\Http\Middleware\CheckToken;
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

Route::middleware([CheckToken::class])->group(function () {
    Route::get('/sabhasad/sabhasad-list', [SabhasadRegistrationController::class, 'getSabhasadList']);
    Route::get('/sabhasad/sabhasad-name-address/{sabhasadNumber}', [SabhasadRegistrationController::class, 'getSabhasadNameAddress']);
    Route::post('/sabhasad/update-verification-status', [SabhasadRegistrationController::class, 'updateVerificationStatus']);
    Route::post('sabhasad/generate-sabhasad-number', [SabhasadRegistrationController::class, 'generateSabhasadNumber']);
    
});
Route::get('/posting/operationalArea/{level}', [AddressDirectoryController::class, 'getOpArea']);
Route::get('/sabhasad/sabhasadDetails/{id}', [SabhasadRegistrationController::class, 'getSabhasadDetails']);
Route::get('/addressDirectory/districts', [AddressDirectoryController::class, 'districtList']);
Route::get('/addressDirectory/talukas/{district}', [AddressDirectoryController::class, 'talukaList']);
Route::get('/addressDirectory/villages', [AddressDirectoryController::class, 'villageList']);
Route::get('/addressDirectory/address/{id}', [AddressDirectoryController::class, 'getAddressDirectory']);
Route::post('/sabhasad/register', [SabhasadRegistrationController::class, 'registerSabhasad']);
Route::post('/sabhasad/submitDocument', [SabhasadRegistrationController::class, 'submitDocument']);
Route::get('/sabhasad/checkDuplicatePhNumber/{value}', [SabhasadRegistrationController::class, 'isPhoneNumberNew']);
Route::get('/sabhasad/checkDuplicateAadharNumber/{value}', [SabhasadRegistrationController::class, 'isAadharNumberNew']);
Route::post('/login', [LoginController::class, 'login']);
