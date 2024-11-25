<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return inertia('Klanten');
});

// Route::get('/klanten', function () {
//     return inertia('Klanten');
// });

Route::get('/klantverzoeken', function () {
    return inertia('Klantverzoeken');
});

// Route::get('/producten', function () {
//     return inertia('Producten');
// });
Route::get('/producten', [ProductController::class, 'index']);

Route::get('/productcategorieën', function () {
    return inertia('productcategorieën');
});

Route::get('/voedselpakketten', function () {
    return inertia('Voedselpakketten');
});

Route::get('/leveranciers', function () {
    return inertia('Leveranciers');
});

Route::get('/medewerkers', function () {
    return inertia('Medewerkers');
});
