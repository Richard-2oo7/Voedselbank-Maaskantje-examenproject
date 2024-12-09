<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\FoodPackController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\SupplierController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;



Route::inertia('/', 'Home')->name('home');

Route::middleware('guest')->group(function(){

    Route::get('/aanmelden', [ClientController::class, 'create'])->name('klantAanmelden');
    Route::post('/klanten', [ClientController::class,'store']);
    
    Route::get('/inloggen', [SessionController::class, 'create'])->name('login');
    Route::post('/inloggen', [SessionController::class, 'store']);
    
    Route::prefix('reset-wachtwoord')->name('resetWachtwoord.')->group(function () {
        Route::get('check-email', [ResetPasswordController::class, 'checkEmailShow'])->name('checkEmail');
        Route::post('check-email', [ResetPasswordController::class, 'checkEmail']);

        Route::get('check-code', [ResetPasswordController::class, 'checkCodeShow'])->name('checkCode');
        Route::post('check-code', [ResetPasswordController::class, 'checkCode']);

        Route::get('maak-wachtwoord', [ResetPasswordController::class, 'createNewPasswordShow'])->name('maakWachtwoord');
        Route::post('maak-wachtwoord', [ResetPasswordController::class, 'createNewPassword']);
    });
    
});


Route::middleware('auth')->group(function(){

    Route::post('/uitloggen', [SessionController::class, 'destroy']);

    //pagina's voor de magazijnmedewerker
    Route::middleware([RoleMiddleware::class. ':magazijnmedewerker'])->group(function(){
        Route::get('/producten', [ProductController::class, 'index'])->name('producten');
        Route::post('/producten', [ProductController::class, 'store']);
        Route::patch('/producten/{id}', [ProductController::class, 'update']);
        Route::delete('/producten', [ProductController::class, 'destroy']);

        Route::get('/leveranciers',  [SupplierController::class, 'index'])->name('leveranciers');
        Route::post('/leveranciers',  [SupplierController::class, 'store']);
        Route::patch('/leveranciers',  [SupplierController::class, 'update']);
        Route::delete('/leveranciers',  [SupplierController::class, 'destroy']);
    });

    //paginas voor de vrijwilliger
    Route::middleware([RoleMiddleware::class. ':vrijwilliger'])->group(function(){
        Route::get('/voedselpakketten', [FoodPackController::class, 'index'])->name('voedselpakketten');
        Route::post('/voedselpakketten', [FoodPackController::class,'store']);
        Route::delete('/voedselpakketten', [FoodPackController::class,'destroy']);
    });

    Route::middleware([RoleMiddleware::class])->group(function(){
        Route::get('/klanten', [ClientController::class, 'index'])->name('klanten');
        Route::patch('/klanten/{id}', [ClientController::class, 'update']);
        Route::delete('/klanten', [ClientController::class,'destroy']);

        Route::get('/klantverzoeken', [ClientController::class, 'indexCLientRequests']);

        Route::get('/medewerkers', [EmployeeController::class,'index'])->name('medewerkers');
        Route::post('/medewerkers',  [EmployeeController::class, 'store']);
        Route::patch('/medewerkers',  [EmployeeController::class, 'update']);
        Route::delete('/medewerkers',  [EmployeeController::class, 'destroy']);

        Route::get('/productcategorieën', [CategoryController::class, 'index'])->name('productcategorieën');
        Route::post('/productcategorieën',  [CategoryController::class, 'store']);
        Route::patch('/productcategorieën',  [CategoryController::class, 'update']);
        Route::delete('/productcategorieën',  [CategoryController::class, 'destroy']);
    });

});