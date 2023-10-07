<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;

use App\Http\Controllers\PathController;
use App\Http\Controllers\FileController;


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/getFilePath', 'App\Http\Controllers\PathController@getFilePath');



Route::get('/file-path', function (Request $request) {
    $filePath = $request->input('file');

    // Check if the file exists
    if (File::exists($filePath)) {
        // Get the absolute path of the file
        $path = realpath($filePath);
        return response()->json(['path' => $path]);
    } else {
        return response()->json(['error' => 'File not found'], 404);
    }
});
