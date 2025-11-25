<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Debugger test route with database queries
Route::get('/debugger-test', function () {
    // Test database queries (commented out - requires database setup)
    // DB::table('users')->count();
    // DB::table('users')->where('id', '>', 0)->limit(10)->get();
    
    // Test logging
    Log::info('Debugger test route accessed');
    Log::debug('Debug message from test route');
    Log::warning('Warning message to test log collector');
    
    // Test session
    session(['debugger_test' => 'Test value from session']);
    
    return view('debugger-test', [
        'title' => 'Laravel Debugger Test',
        'message' => 'This page demonstrates the Laravel Debugger package',
        'features' => [
            'Request tracking',
            'Database query monitoring',
            'Log collection',
            'Performance metrics',
            'View debugging',
        ],
    ]);
})->name('debugger.test');
