<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\customercontroller;
use App\Http\Controllers\CusController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\headcontroller;



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


 // leader
Route::resource('Cus',CusController::class);
Route::post('Cus/search/data', [CusController::class, 'search'])->name('Cus.search');
Route::get('Cus/Cusleadertbl2/data/', [CusController::class, 'searchTBL2'])->name('Cus.Search_Cusleadertbl2');
Route::get('Cus/dashboard/data', [CusController::class, 'dashboard'])->name('Cus.dashboard');


Route::post('Cus/search/getData', [CusController::class, 'getData'])->name('Cus.getData');
Route::get('Cus/export/',[CusController::class, 'export'])->name('export.excel');
Route::post('Cus/import/',[CusController::class, 'import'])->name('import.excel');
 
});

Route::get('auth/register',function(){
    return view('auth/register');
});
