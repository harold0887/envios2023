<?php

use App\Http\Livewire\Balance;
use App\Http\Livewire\CartRender;
use App\Http\Livewire\Presupuesto;
use Illuminate\Support\Facades\Auth;
use App\Http\Livewire\MembershipList;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
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
  route::get('/balance', Balance::class)->name('balance');
  route::get('/presupuesto', Presupuesto::class)->name('presupuesto');
  route::get('/membresias', MembershipList::class)->name('membresias');

  Route::get('/foo', function () {
    Artisan::call('storage:link');
    echo "Link done";
  });


  // Clear application cache:
  Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    return 'Application cache has been cleared';
  });

  //Clear route cache:
  Route::get('/route-cache', function () {
    Artisan::call('route:cache');
    return 'Routes cache has been cleared';
  });

  //Clear config cache:
  Route::get('/config-cache', function () {
    Artisan::call('config:cache');
    return 'Config cache has been cleared';
  });

  // Clear view cache:
  Route::get('/view-clear', function () {
    Artisan::call('view:clear');
    return 'View cache has been cleared';
  });
});
