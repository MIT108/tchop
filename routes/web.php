<?php

use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InfoUserController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\SessionsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\MenuController;

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


Route::group(['middleware' => 'auth'], function () {

    Route::get('/', [HomeController::class, 'home']);
	Route::get('dashboard', function () {
		return view('dashboard');
	})->name('dashboard');

	Route::get('billing', function () {
		return view('billing');
	})->name('billing');

	Route::get('profile', function () {
		return view('profile');
	})->name('profile');

	Route::get('rtl', function () {
		return view('rtl');
	})->name('rtl');

	Route::get('user-management', function () {
		return view('laravel-examples/user-management');
	})->name('user-management');


    //custom routes

	Route::get('client-management', [CustomerController::class, 'index'] )->name('client-management');
    Route::post('customer-create', [CustomerController::class, 'create'])->name('customer-create');
    Route::get('customer/list', [CustomerController::class, 'getCustomers'])->name('customers.list');
    Route::get('customer/suspend/{id}', [CustomerController::class, 'suspendCustomer'])->name('suspend.customer');
    Route::get('customer/activate/{id}', [CustomerController::class, 'activateCustomer'])->name('activate.customer');
    Route::get('customer/delete/{id}', [CustomerController::class, 'deleteCustomer'])->name('delete.customer');
    Route::get('customer/{id}', [CustomerController::class, 'viewCustomer'])->name('view.customer');



    //menu Routes

    Route::get('menu-management', [MenuController::class, 'index'])->name('menu-management');
    Route::post('create/menu', [MenuController::class, 'createMenu'])->name('create.menu');
    Route::post('update/menu', [MenuController::class, 'updateMenu'])->name('update.menu');
    Route::get('menu/{id}', [MenuController::class, 'viewMenu'])->name('view.menu');
    Route::post('menu/ingredients/{id}', [MenuController::class, 'menuIngredient'])->name('menu.ingredient');


    //ingredient routes

    Route::post('create/ingredient', [IngredientController::class, 'createIngredient'])->name('create.ingredient');
    Route::post('update/ingredient', [IngredientController::class, 'updateIngredient'])->name('update.ingredient');
    Route::get('ingredient/delete/{id}', [IngredientController::class, 'deleteIngredient'])->name('delete.ingredient');
    Route::get('ingredient/{id}', [IngredientController::class, 'viewIngredient'])->name('view.ingredient');




	Route::get('tables', function () {
		return view('tables');
	})->name('tables');

    Route::get('virtual-reality', function () {
		return view('virtual-reality');
	})->name('virtual-reality');

    Route::get('static-sign-in', function () {
		return view('static-sign-in');
	})->name('sign-in');

    Route::get('static-sign-up', function () {
		return view('static-sign-up');
	})->name('sign-up');

    Route::get('/logout', [SessionsController::class, 'destroy']);
	Route::get('/user-profile', [InfoUserController::class, 'create']);
	Route::post('/user-profile', [InfoUserController::class, 'store']);
    Route::get('/login', function () {
		return view('dashboard');
	})->name('sign-up');
});



Route::group(['middleware' => 'guest'], function () {
    Route::get('/register', [RegisterController::class, 'create']);
    Route::post('/register', [RegisterController::class, 'store']);
    Route::get('/login', [SessionsController::class, 'create']);
    Route::post('/session', [SessionsController::class, 'store']);
	Route::get('/login/forgot-password', [ResetController::class, 'create']);
	Route::post('/forgot-password', [ResetController::class, 'sendEmail']);
	Route::get('/reset-password/{token}', [ResetController::class, 'resetPass'])->name('password.reset');
	Route::post('/reset-password', [ChangePasswordController::class, 'changePassword'])->name('password.update');

});

Route::get('/login', function () {
    return view('session/login-session');
})->name('login');
