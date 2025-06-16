<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\KostumController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderItemController;
use App\Http\Controllers\Admin\HistoryOrderController;
use App\Http\Controllers\Admin\PengembalianController;
use App\Http\Controllers\Admin\ProductScheduleController;

Route::get('/', [FrontendController::class, 'home']);
Route::get('/pengajuan', [FrontendController::class, 'pengajuan'])->middleware('auth');
Route::get('/pesanan', [FrontendController::class, 'pesanan'])->middleware('auth');
Route::get('/pesananresep', [FrontendController::class, 'pesananresep'])->middleware('auth');
Route::get('/profile', [FrontendController::class, 'profile'])->middleware('auth');

Route::redirect('/loginadmin', '/login');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Profile
    Route::delete('profiles/destroy', 'ProfileController@massDestroy')->name('profiles.massDestroy');
    Route::post('profiles/media', 'ProfileController@storeMedia')->name('profiles.storeMedia');
    Route::post('profiles/ckmedia', 'ProfileController@storeCKEditorImages')->name('profiles.storeCKEditorImages');
    Route::resource('profiles', 'ProfileController');

    // Category
    Route::resource('categories', CategoryController::class);
    Route::delete('categories/mass-destroy', [CategoryController::class, 'massDestroy'])->name('categories.massDestroy');


    // Kostum
    Route::delete('kostums/destroy', [KostumController::class, 'massDestroy'])->name('kostums.massDestroy');
    Route::resource('/kostums', KostumController::class);
    Route::post('kostums/media', 'KostumController@storeMedia')->name('kostums.storeMedia');

    // Product Schedule
    Route::resource('/product-schedules', ProductScheduleController::class);
    Route::delete('product-schedules/mass-destroy', [ProductScheduleController::class, 'massDestroy'])->name('admin.product-schedules.massDestroy');

    // Order
    Route::resource('orders', OrderController::class);
    Route::delete('orders/mass-destroy', [OrderController::class, 'massDestroy'])->name('orders.massDestroy');
    Route::get('/order/create', [OrderController::class, 'create'])->name('order.create');
    Route::post('/order', [OrderController::class, 'store'])->name('order.store');

    // Order Item
    Route::resource('admin/order-items', OrderItemController::class);
    // Pastikan rute mass-destroy hanya ada satu kali prefix admin
    Route::post('admin/order-items/mass-destroy', [OrderItemController::class, 'massDestroy'])->name('order-items.massDestroy');
    
    // Pengembalian
    Route::resource('pengembalians', PengembalianController::class);
    Route::delete('pengembalians/mass-destroy', [PengembalianController::class, 'massDestroy'])->name('pengembalians.massDestroy');

    // History Order
    Route::resource('history-orders', HistoryOrderController::class);
    Route::delete('history-orders/mass-destroy', [HistoryOrderController::class, 'massDestroy'])->name('history-orders.massDestroy');
});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});

Route::post('/login', function (Request $request) {
    // JANGAN Request::only(), tapi $request->only()
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return response()->json(['status' => 'success']);
    }

    return response()->json(['status' => 'error', 'message' => 'Email atau password salah']);
});

Route::post('/register', [FrontendController::class, 'register']);



