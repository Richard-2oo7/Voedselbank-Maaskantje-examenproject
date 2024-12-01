<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\FoodPackController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Home')->name('home');


Route::get('/inloggen', [SessionController::class, 'create'])->name('inloggen');
Route::post('/inloggen', [SessionController::class, 'store']);


Route::prefix('reset-wachtwoord')->name('resetWachtwoord.')->group(function () {
    Route::get('check-email', [EmployeeController::class, 'checkEmailShow'])->name('checkEmail'); // wachtwoord-vergeten/check-email
    Route::post('check-email', [EmployeeController::class, 'checkEmail']); // wachtwoord-vergeten/check-email

    Route::get('check-code', [EmployeeController::class, 'checkCodeShow'])->name('checkCode'); // wachtwoord-vergeten/check-code
    Route::post('check-code', [EmployeeController::class, 'checkCode']); // wachtwoord-vergeten/check-code

    Route::get('maak-wachtwoord', [EmployeeController::class, 'createNewPasswordShow'])->name('maakWachtwoord'); // wachtwoord-vergeten/maak-password
    Route::patch('maak-wachtwoord', [EmployeeController::class, 'createNewPassword']); // wachtwoord-vergeten/make-password
});


Route::get('/wachtwoord-resetten', [EmployeeController::class, 'wachtwoordAanpassen']);


Route::get('/aanmelden', [ClientController::class, 'create'])->name('klantAanmelden');
Route::get('/klanten', [ClientController::class, 'index'])->name('klanten');
Route::post('/klanten', [ClientController::class,'store']);
Route::patch('/klanten/{id}', [ClientController::class, 'update']);
Route::delete('/klanten', [ClientController::class,'destroyMultiple']);

Route::get('/producten', [ProductController::class, 'index'])->name('producten');
Route::post('/producten', [ProductController::class,'store']);
Route::patch('/producten/{id}', [ProductController::class, 'update']);
Route::delete('/producten', [ProductController::class,'destroyMultiple']);


Route::get('/klantverzoeken', function () {
    return inertia('Klantverzoeken');
});


Route::get('/productcategorieën', function () {
    return inertia('productcategorieën');
});

Route::get('/voedselpakketten', [FoodPackController::class, 'index'])->name('producten');
Route::post('/voedselpakketten', [FoodPackController::class,'store']);
Route::patch('/voedselpakketten/{id}', [FoodPackController::class, 'update']);
Route::delete('/voedselpakketten', [FoodPackController::class,'destroyMultiple']);

Route::get('/leveranciers', function () {
    return inertia('Leveranciers');
});

Route::get('/medewerkers', function () {
    return inertia('Medewerkers');
});
