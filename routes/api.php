<?php

use App\Http\Controllers\API\JobsController;
use Illuminate\Support\Facades\Route;

Route::name('api.jobs.')
    ->prefix('jobs')
    ->group(function () {
        Route::get('/', [JobsController::class, 'index'])->name('list');
        Route::get('/{job}', [JobsController::class, 'show'])->name('show');

        Route::middleware('auth:sanctum')
            ->group(function () {
                Route::get('/{job}/apply', [JobsController::class, 'apply'])->name('apply');

                Route::get('/create', [JobsController::class, 'create'])->name('create');
                Route::post('/', [JobsController::class, 'store'])->name('store');
                Route::get('/{job}/edit', [JobsController::class, 'edit'])->name('edit');
                Route::put('/{job}', [JobsController::class, 'update'])->name('update');
                Route::delete('/{job}', [JobsController::class, 'destroy'])->name('destroy');
            });
    });
