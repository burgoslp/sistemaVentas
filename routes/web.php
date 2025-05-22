<?php

use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\orderController;
use App\Http\Controllers\UserController;
use App\Models\Budget;

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


// Rutas de autenticación
Route::controller(AuthController::class)->group(function () {

    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'login');
    Route::post('/logout', 'logout')->name('logout');
});

Route::group(['middleware'=>['auth']], function(){
        
    Route::get('/home', [HomeController::class,'index'])->name('home');

    Route::get('/articulos', [ArticleController::class, 'index'])->name('articulos');

    
    Route::get('/presupuestos', [BudgetController::class,'index'])->name('presupuestos');
    Route::get('/presupuestos/create', [BudgetController::class,'create'])->name('presupuestos.create');
    Route::post('/presupuestos', [BudgetController::class,'store'])->name('presupuestos.store');
    Route::delete('/presupuestos/{id}', [BudgetController::class, 'destroy'])->name('presupuestos.destroy');
    Route::get('/presupuestos/show/{id}', [BudgetController::class, 'show'])->name('presupuestos.show');
    Route::put('/presupuestos/{id}', [BudgetController::class, 'update'])->name('presupuestos.update');
    Route::put('/presupuestos/aprove/{id}', [BudgetController::class, 'approveBudget'])->name('presupuestos.aprove');
    Route::get('/presupuestos/historico', [BudgetController::class, 'historico'])->name('presupuestos.historico');


    Route::get('/pedidos', [orderController::class,'index'])->name('pedidos');
    Route::get('/pedidos/show/{id}', [orderController::class, 'show'])->name('pedidos.show');
    Route::delete('/pedidos/{id}', [orderController::class, 'destroy'])->name('pedidos.destroy');
    Route::put('/pedidos/{id}', [orderController::class, 'update'])->name('pedidos.update');
    Route::put('/pedidos/aprove/{id}', [orderController::class, 'approveOrder'])->name('pedidos.aprove');
    Route::get('/pedidos/historico', [orderController::class, 'historico'])->name('pedidos.historico');


    Route::get('/historicos', [HistoryController::class,'index'])->name('historicos');


    Route::get('/usuarios', [UserController::class,'index'])->name('usuarios')->middleware(['role:ADMIN']);
    Route::get('/usuarios/create', [UserController::class,'create'])->name('usuarios.create')->middleware(['role:ADMIN']);
    Route::post('/usuarios', [UserController::class,'store'])->name('usuarios.store')->middleware(['role:ADMIN']);
    Route::delete('/usuarios/{id}', [UserController::class,'destroy'])->name('usuarios.destroy')->middleware(['role:ADMIN']);
    Route::get('/usuarios/show/{id}', [UserController::class, 'show'])->name('usuarios.show')->middleware(['role:ADMIN']);
    Route::put('/usuarios/{id}', [UserController::class, 'update'])->name('usuarios.update');
});



