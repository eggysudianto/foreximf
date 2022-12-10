<?php

use Illuminate\Support\Facades\Route;

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
    return redirect('login');
});

Auth::routes();

Route::group(['middleware' => ['auth']], function () {
    Route::get('/member', [App\Http\Controllers\MemberController::class, 'index'])->name('member');
    Route::get('/tree_view', [App\Http\Controllers\MemberController::class, 'treeview'])->name('tree_view');

    Route::get('/panel', [App\Http\Controllers\PanelController::class, 'index'])->name('panel');
    Route::post('/panel/get_recursive_child', [App\Http\Controllers\PanelController::class, 'get_recursive_child'])->name('get_recursive_child');
    Route::post('/panel/register_member_baru', [App\Http\Controllers\PanelController::class, 'register_member_baru'])->name('register_member_baru');

    Route::post('/panel/get_parent', [App\Http\Controllers\PanelController::class, 'get_parent'])->name('get_parent');
    Route::post('/panel/migrasi', [App\Http\Controllers\PanelController::class, 'migrasi'])->name('migrasi');
});