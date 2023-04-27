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
    return view('welcome');
});

Route::get('/sabhasad-register', function () {
    return view('register_form');
});

Route::get('/thanks', function () {
    return view('thanks_page');
});

Route::get('storage/{filPath}/{fileName}', function ($filePath, $fileName){
   // return $filename;
    $path = storage_path('app/public/'.$filePath.'/'. $fileName);
    //return $path;
    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});

Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '^(?!api).*$');