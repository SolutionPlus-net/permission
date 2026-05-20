<?php

use Illuminate\Support\Facades\Route;
use Otas\Permission\Http\Controllers\PermissionGroupController;
use Otas\Permission\Http\Controllers\PermissionController;
use Otas\Permission\Http\Controllers\RoleController;

Route::group([
    'middleware' => array_unique(array_merge(config('permissions.middlewares'), [
        'auth:api',
        'permission-officer',
        'translatable',
    ]))
], function () {
    Route::apiResource('permission-groups', PermissionGroupController::class);
    Route::apiResource('permissions', PermissionController::class, ['except', ['store', 'destroy']]);
    Route::apiResource('roles', RoleController::class);
});
