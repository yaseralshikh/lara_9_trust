<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\BackendController;
use App\Http\Livewire\Backend\Admin\Dashboard\Dashboard;
use App\Http\Livewire\Backend\Admin\Users\ListPermissions;
use App\Http\Livewire\Backend\Admin\Users\ListRoles;
use App\Http\Livewire\Backend\Admin\Users\ListUsers;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::group(['middleware' => 'guest'], function () {
        Route::get('login', [BackendController::class, 'login'])->name('login');
    });

    Route::group(['middleware' => ['auth', 'role:admin|superadmin']], function (){
        Route::get('/', Dashboard::class)->name('index');
        Route::get('users', ListUsers::class)->name('users');
        Route::get('roles', ListRoles::class)->name('roles');
        Route::get('permissions', ListPermissions::class)->name('permissions');
    });
});

