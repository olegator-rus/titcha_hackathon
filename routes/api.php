<?php

use App\Http\Controllers\API\v1\AuthController;
use App\Http\Controllers\API\v1\WalletController;
use App\Http\Controllers\API\v1\CardController;
use App\Http\Controllers\API\v1\HistoryController;
use App\Http\Controllers\API\v1\AccountController;
use App\Http\Controllers\API\v1\BankController;
use App\Http\Controllers\API\v1\UserController;
use App\Http\Controllers\API\v1\CurrencyController;
use Illuminate\Support\Facades\Route;

// Роуты доступные не аутентифицрованным пользователям
Route::group(['middleware' => ['api', 'cors']], function() {
    Route::prefix('/user')->group(function(){
        Route::post('/login', [ AuthController::class, 'login' ]);
    });
});

// Общие роуты аутентифицированных пользователей
Route::group(['middleware' => ['auth:api']], function() {
    Route::prefix('/user')->group(function(){
        Route::get('/all', [ UserController::class, 'all' ]);
        Route::get('/get', [ UserController::class, 'get' ]);
        Route::patch('/update', [ UserController::class, 'update' ]);
        Route::post('/me', [ UserController::class, 'me' ]);
    });

    // Работа с сущностью карты
    Route::prefix('/card')->group(function(){
        Route::get('/my', [ CardController::class, 'all']);
        Route::get('/get', [ CardController::class, 'get']);
        Route::post('/create', [ CardController::class, 'create']);
        Route::post('/transaction', [ CardController::class, 'transaction']);
        Route::delete('/remove', [ CardController::class, 'remove']);
    });

    // Работа с сущностью кошелька
    Route::prefix('/wallet')->group(function(){
        Route::get('/all', [ WalletController::class, 'all']);
        Route::get('/my', [ WalletController::class, 'my']);
        Route::get('/get', [ WalletController::class, 'get']);
        Route::post('/transaction', [ WalletController::class, 'transaction']);
        Route::post('/create', [ WalletController::class, 'create']);
    });

    // Для работы суперадмина с сущностью банков
    Route::prefix('/bank')->group(function(){
        Route::get('/all', [ BankController::class, 'all']);
        Route::get('/get', [ BankController::class, 'get']);
        Route::post('/create', [ BankController::class, 'create']);
        Route::patch('/update', [ BankController::class, 'update']);
        Route::delete('/remove', [ BankController::class, 'remove']);
    });

    // Работа с сущностью карты
    Route::prefix('/history')->group(function(){
        Route::get('/my', [ HistoryController::class, 'my']);
    });

    // Работа с сущностью карты
    Route::prefix('/currency')->group(function(){
        Route::get('/all', [ CurrencyController::class, 'all']);
        Route::get('/rates', [ CurrencyController::class, 'rates']);
    });

    // Работа с сущностью счета
    Route::prefix('/account')->group(function(){
        Route::get('/my', [ AccountController::class, 'my']);
        Route::post('/topup', [ AccountController::class, 'topup']);
    });

});
