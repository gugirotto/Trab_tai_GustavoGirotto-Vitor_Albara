<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', function (Request $r) {
    if ($r->session()->get('user_id') == "") {
        return redirect('/login');
    } else if (Session::has('user_id')) {
        $username = $r->session()->get('user_nome');
        $capsule = array('username' => $username);
        return view('/protect')->with($capsule);
    } else {
        return redirect('/login');
    }
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/create_account', "App\Http\Controllers\Login_con@index");
Route::post('/create', "App\Http\Controllers\Login_con@create");
Route::get('/login', "App\Http\Controllers\Login_con@login");
Route::post('/check', 'App\Http\Controllers\Login_con@check_user');
Route::get('/welcome', 'App\Http\Controllers\Login_con@protect');
Route::get('/logout', 'App\Http\Controllers\Login_con@logout');

    Route::post('/create_car', 'App\Http\Controllers\Carro_con@createc');
    Route::get('/create_carro', 'App\Http\Controllers\Carro_con@index');
    Route::get('/Ver_carro', 'App\Http\Controllers\Carro_con@fetchcar');
    Route::get('/Edit_Carro/{id}', 'App\Http\Controllers\Carro_con@Editcarro');
    Route::post('/update_car', 'App\Http\Controllers\Carro_con@updatecar');
    Route::get('/Delete_Carro/{id}', 'App\Http\Controllers\Carro_con@removecarro');
    Route::post('/achar_carro', "App\Http\Controllers\Carro_con@searchcar");
    Route::get('/pdfview_carro', 'App\Http\Controllers\Carro_con@pdfview');
    Route::get('/email_carro', 'App\Http\Controllers\Carro_con@sendEmail');
    


    Route::get('/create_mecanico', 'App\Http\Controllers\Mecanico_con@index');
    Route::post('/create_mec', 'App\Http\Controllers\Mecanico_con@create');
    Route::get('/Ver_mecanico', 'App\Http\Controllers\Mecanico_con@fetch');
    Route::get('/Edit_mecanico/{id}', 'App\Http\Controllers\Mecanico_con@Edit');
    Route::post('/update_mecanico', 'App\Http\Controllers\Mecanico_con@update');
    Route::get('/Delete_mecanico/{id}', 'App\Http\Controllers\Mecanico_con@remove');
    Route::post('/achar_mecanico', "App\Http\Controllers\Mecanico_con@search");
    Route::get('/pdfview_mecanico', 'App\Http\Controllers\Mecanico_con@pdfview');
    Route::get('/email_mecanico', 'App\Http\Controllers\Mecanico_con@sendEmail');

    Route::get('/create_serviço', 'App\Http\Controllers\Serviço_con@index');
    Route::post('/create_serv', 'App\Http\Controllers\Serviço_con@create');
    Route::get('/Ver_serviço', 'App\Http\Controllers\Serviço_con@fetch');
    Route::get('/Edit_serviço/{id}', 'App\Http\Controllers\Serviço_con@Edit');
    Route::post('/update_serviço', 'App\Http\Controllers\Serviço_con@update');
    Route::get('/Delete_serviço/{id}', 'App\Http\Controllers\Serviço_con@remove');
    Route::post('/achar_serviço', "App\Http\Controllers\Serviço_con@search");
    Route::get('/pdfview_serviço', 'App\Http\Controllers\Serviço_con@pdfview');
    Route::get('/email_serviço', 'App\Http\Controllers\Serviço_con@sendEmail');

