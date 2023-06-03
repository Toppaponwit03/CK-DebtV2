<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\customercontroller;
use App\Http\Controllers\CusController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\headcontroller;
use App\Http\Controllers\StaticController;
use App\Http\Controllers\ComController;


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
    return view('auth/login');
});

/*Route::get('/registerUser', function () {
    return view('/register');
});*/
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {


Route::resource('Cus',CusController::class);
Route::get('Cus/dashboard/data', [CusController::class, 'dashboard'])->name('Cus.dashboard');
Route::post('Cus/search/getData', [CusController::class, 'getData'])->name('Cus.getData');
Route::post('Cus/export/',[CusController::class, 'export'])->name('export.excel');
Route::post('Cus/import/',[CusController::class, 'import'])->name('import.excel');

Route::resource('static',StaticController::class);


// ระบบคำนวนค่าคอม

Route::resource('Com',ComController::class);
Route::post('Com/export/',[ComController::class, 'export'])->name('Com.export');
});

Route::get('auth/register',function(){
    return view('auth/register');
});
