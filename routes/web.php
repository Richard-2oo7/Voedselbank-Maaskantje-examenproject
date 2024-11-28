<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\FoodPackController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Home');

// Route::get('/klanten', function () {
//     return inertia('Klanten');
// });


// Route::get('/producten', function () {
//     return inertia('Producten');
// });
Route::get('/klanten', [ClientController::class, 'index']);
Route::post('/klanten', [ClientController::class,'store']);
Route::patch('/klanten/{id}', [ClientController::class, 'update']);
Route::delete('/klanten', [ClientController::class,'destroyMultiple']);

Route::get('/producten', [ProductController::class, 'index']);
Route::post('/producten', [ProductController::class,'store']);
Route::patch('/producten/{id}', [ProductController::class, 'update']);
Route::delete('/producten', [ProductController::class,'destroyMultiple']);


Route::get('/klantverzoeken', function () {
    return inertia('Klantverzoeken');
});


Route::get('/productcategorieën', function () {
    return inertia('productcategorieën');
});

Route::get('/voedselpakketten', [FoodPackController::class, 'index']);
Route::post('/voedselpakketten', [FoodPackController::class,'store']);
Route::patch('/voedselpakketten/{id}', [FoodPackController::class, 'update']);
Route::delete('/voedselpakketten', [FoodPackController::class,'destroyMultiple']);

Route::get('/leveranciers', function () {
    return inertia('Leveranciers');
});

Route::get('/medewerkers', function () {
    return inertia('Medewerkers');
});
