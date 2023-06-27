<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Main\Actions\SearchRestaurantsAction;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/search', function(Request $request, SearchRestaurantsAction $action) {
    $genre = $request->input('genre');
    $large_area = $request->input('large_area');
    $middle_area = $request->input('middle_area');

    return $action->search($genre, $large_area, $middle_area);
});