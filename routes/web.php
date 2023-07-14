<?php

use App\Http\Livewire\Balance;
use App\Http\Livewire\CartRender;
use App\Http\Livewire\Presupuesto;
use App\Http\Livewire\MembershipList;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EgresosController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminSalesControler;
use App\Http\Controllers\AdminPackageController;
use App\Http\Controllers\AdminProductsController;
use App\Http\Controllers\AdminMembershipController;



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





Auth::routes();





Route::group(['middleware' => ['auth']], function () {
  Route::get('/', [HomeController::class, 'index'])->name('home');
  Route::get('dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

  Route::resource('dashboard/products', AdminProductsController::class)->except(['show']);
  Route::resource('dashboard/memberships', AdminMembershipController::class)->except(['show']);
  Route::resource('dashboard/package', AdminPackageController::class)->except(['show']);
  Route::resource('dashboard/sales', AdminSalesControler::class)->except(['delete']);

  Route::get('cart', CartRender::class)->name('cart.index');


  Route::get('profile', [HomeController::class, 'profile'])->name('profile.edit');
  Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::put('profile/password', [ProfileController::class, 'password'])->name('profile.password');


  Route::resource('payments', EgresosController::class);
  route::get('/balance',Balance::class)->name('balance');
  route::get('/presupuesto',Presupuesto::class)->name('presupuesto');
  route::get('/membresias',MembershipList::class)->name('membresias');
});
