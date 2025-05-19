<?php

use App\Http\Controllers\Compro\GetLastArticleController;
use App\Http\Controllers\Compro\LastAppController;
use App\Http\Controllers\Compro\SearchArticleController;
use App\Http\Controllers\Compro\ShowArticleController;
use App\Http\Controllers\Dashboard\AppHistoryController;
use App\Http\Controllers\Dashboard\AuthController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\ManageAdminController;
use App\Http\Controllers\Dashboard\ManageBlindstickController;
use App\Http\Controllers\Dashboard\ManageCategoryController;
use App\Http\Controllers\Dashboard\ManagePemantauController;
use App\Http\Controllers\Dashboard\ManagePenyandangController;
use App\Http\Controllers\Dashboard\ManagePostController;
use App\Http\Controllers\Dashboard\ManageTagController;
use Illuminate\Support\Facades\Route;

Route::prefix('dashboard')->group(function () {

    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('role:super_admin')->group(function () {
            Route::apiResource('/manage-admin', ManageAdminController::class)->except('update');
            Route::post('/manage-admin/reset-password', [ManageAdminController::class, 'resetPassword']);

            Route::apiResource('/app-history', AppHistoryController::class)->except('update');
        });

        Route::middleware('role:super_admin|admin')->group(function () {
            Route::get('/', DashboardController::class);

            Route::apiResource('/manage-category', ManageCategoryController::class);

            Route::apiResource('/manage-tag', ManageTagController::class);

            Route::apiResource('/manage-post', ManagePostController::class);

            Route::apiResource('/manage-pemantau', ManagePemantauController::class)->only('index', 'show');
            Route::get('/manage-pemantau/{id}/get-last-map', [ManagePemantauController::class, 'getLastMap']);

            Route::apiResource('/manage-penyandang', ManagePenyandangController::class)->only('index', 'show');
            Route::get('/manage-penyandang/{id}/get-status-blindstick', [ManagePenyandangController::class, 'latestStatusBlindstick']);

            Route::apiResource('/manage-blindstick', ManageBlindstickController::class)->except('destroy');

            Route::get('/profile/me', [AuthController::class, 'me']);
            Route::post('/profile/change-password', [AuthController::class, 'changePassword']);

            Route::post('/logout', [AuthController::class, 'logout']);
        });
    });

    Route::middleware('guest')->group(function () {
        Route::post('/login', [AuthController::class, 'login']);
    });
});

Route::prefix('guest-compro')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::prefix('article')->group(function () {
            Route::get('/', SearchArticleController::class);
            Route::get('/{slug}', ShowArticleController::class);
            Route::get('/last', GetLastArticleController::class);
        });

        Route::get('/get-app', LastAppController::class);
    });
});
