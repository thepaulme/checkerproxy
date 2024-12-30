<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProxyCheckerController;
use App\Http\Controllers\ProxyHistoryController;

Route::get('/', [ProxyCheckerController::class, 'index'])->name('proxy.index');
Route::post('/check-proxies', [ProxyCheckerController::class, 'checkProxies'])->name('proxy.check');
Route::get('/check-progress/{id}', [ProxyCheckerController::class, 'checkProgress'])->name('proxy.check.progress');

Route::get('/history', [ProxyHistoryController::class, 'history'])->name('proxy.history');
Route::get('/history/{id}', [ProxyHistoryController::class, 'show'])->name('proxy.history.show');