<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AdminConfirmationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminRegistrationController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserConfirmationController;
use App\Http\Controllers\UserRegistrationController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Middleware\AdminAuthenticate;
use App\Http\Kernel;
use App\Http\Middleware\UserAuthenticate;
use App\Models\Address;
use App\Models\Admin;
use App\Models\Product;


Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/authadmin', function(){
    
});



Route::get('/admin-confirm-code', function (Request $request) {
    $token = $request->query('token'); // Captura o token da URL

    if (!$token) {
        abort(403, 'Token não fornecido.');
    }

    return view('admin/adminConfirmCode', ['token' => $token]);
})->name('admin.confirm.code');

Route::get('/admin-register-data', function (Request $request) {
    $token = $request->query('token'); // Captura o token da URL

    if (!$token) {
        abort(403, 'Token não fornecido.');
    }

    return view('admin/adminRegisterData', ['token' => $token]);
})->name('admin.register.data');

Route::get('/admin-login', function () {
    return view('admin/adminLogin');
})->name('admin.login');

Route::get('/first-acess-admin-email', [AdminController::class, 'firstAcessAdminEmail'])->name('admin.first.acess.email');

Route::get('/admin-first-acess', [AdminController::class, 'adminFirstAcess'])->name('admin.first.acess');

Route::post('/admin-register-post', [AdminRegistrationController::class, 'register'])->name('admin.register.post');

Route::post('/admin-confirm-code-post', [AdminConfirmationController::class, 'ConfirmCode'])->name('admin.confirm.code.post');

Route::post('/user-register-post', [UserRegistrationController::class, 'register'])->name('user.register.post');

Route::get('/user-register', function () {
    return view('user/UserRegister');
})->name('user.register');


Route::get('/user-registration-confirmation', action: function (Request $request) {
    
    $email = session('email');


    if (!$email) {
        abort(403, 'Dados não fornecidos.');
    }

    return view('user/confirmRegisterCode', ['email' => $email]);
})->name('user.register.confirmation');


Route::post('/user-register-confirmation-code-post', [UserConfirmationController::class, 'confirmCode'])->name('user.register.confirmation.code.post');

Route::post('/user-login-post', [UserController::class, 'login'])->name('user.login.post');

Route::get('/user-login', function () {
    return view('user/login');
})->name('user.login');


//Rotas do admin
Route::post('/admin-login-post', [AdminController::class, 'login'])->name('admin.login.post');

Route::prefix('admin')->middleware(AdminAuthenticate::class)->group(function () {

    Route::get('admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    
    // Configurações
    Route::get('/settings', [AdminDashboardController::class, 'settings'])->name('admin.settings');
    Route::post('/settings', [AdminDashboardController::class, 'updateSettings'])->name('admin.settings.update');
    Route::get('/logout', [AdminController::class, 'destroy'])->name('admin.logout');

    Route::get('/add-product', function () {
        return view('admin/addProduct');
    })->name('admin.add.product');
    Route::post('/add-product-post', [ProductController::class, 'store'])->name('admin.add.product.post');


    //editar produto
    Route::get('/edit-products', function(){
        return view('admin/editProducts');
    })->name('admin.edit.products');

   Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');

   Route::get('/products/ajax-search', [ProductController::class, 'ajaxSearch'])->name('products.ajaxSearch');

   Route::post('/products/edit-products-post', [ProductController::class, 'update'])->name('admin.edit.products.post');

   Route::delete('/products/edit-delete-post', [ProductController::class, 'destroy'])->name('admin.edit.products.delete');

});

Route::prefix('user')->middleware(UserAuthenticate::class)->group(function() {

Route::get('/dashboard', [UserController::class, 'index'])->name('user.dashboard');
Route::get('/settings', [UserController::class, 'settings'])->name('user.settings');
Route::post('/settings', [UserController::class, 'updateSettings'])->name('user.settings.update');
Route::get('/logout', [UserController::class, 'destroy'])->name('user.logout');
Route::get('/delete-account', [UserController::class, 'deleteAccount'])->name('user.delete.account');
Route::post('/delete-account', [UserController::class, 'confirmDeleteAccount'])->name('user.confirm.delete.account');
Route::post('/cart-add', [CartController::class, 'add'])->name('user.cart.add');
Route::post('/buy-product', [UserController::class, 'buyProduct'])->name('user.buy.now');
Route::get('/cart', [CartController::class, 'index'])->name('user.cart');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/checkout-cart', [UserController::class, 'buyCart'])->name('user.checkout.cart.post');
Route::post('/checkout-product', [UserController::class, 'buyProduct'])->name('user.checkout.product.post');
 Route::get('/checkout-cart/{orderId}', [CheckoutController::class, 'checkoutCart'])->name('user.checkout.cart.get');
Route::get('/checkout/{orderId}', [CheckoutController::class, 'checkout'])->name('user.checkout');
Route::get('/address', [AddressController::class, 'show'])->name('user.show.address');
Route::get('/address-register-form',[AddressController::class, 'showForm'])->name('user.register.address');
Route::post('/address-register',[AddressController::class, 'store'])->name('user.register.address.post');
Route::get('/order/itens', [OrderItemController::class, 'showOrderItems'])->name('user.order.items');





});

//produtos
Route::get('/product', [ProductController::class, 'index'])->name('product.index');
Route::get('/product/image/{id}', [ProductController::class, 'image'])->name('product.image');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');
