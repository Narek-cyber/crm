<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TariffController;
use App\Http\Controllers\Api\CompanyController;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');

Route::group(['middleware' => 'api', 'headers' => ['Content-Type' => 'application/json']], function () {
    Route::match('post', 'login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('registration', [AuthController::class, 'registration'])->name('auth.registration');
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('companies', [CompanyController::class, 'store'])->name('companies.store');
    Route::post('companies/{company}/invite', [CompanyController::class, 'invite'])->name('user.invite');
    Route::post('logout', [AuthController::class, 'logout']);
})->name('auth');

Route::resource('tariffs', TariffController::class);

