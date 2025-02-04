<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TariffController;
use App\Http\Controllers\Api\CompanyController;
use App\Enums\RolesEnum;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');

Route::group(['middleware' => 'api', 'headers' => ['Content-Type' => 'application/json']], function () {
    Route::post('login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('registration', [AuthController::class, 'registration'])->name('auth.registration');
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('companies', [CompanyController::class, 'store'])->name('companies.store');
    Route::post('companies/{company}/invite', [CompanyController::class, 'invite'])->name('user.invite');
    Route::middleware(['role:' . RolesEnum::ADMIN->value])->group(function () {
        Route::resource('tariffs', TariffController::class);
    });
    Route::post('logout', [AuthController::class, 'logout']);
})->name('auth');



