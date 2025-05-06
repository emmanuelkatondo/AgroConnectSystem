<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\DashboardController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/login', [MainController::class, 'showLoginForm'])->name('login');
Route::post('/login', [MainController::class, 'login']);
Route::get('/register', [MainController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [MainController::class, 'register']);

Route::get('/regions', [MainController::class, 'getRegions']);
Route::get('/districts/{region}', [MainController::class, 'getDistricts']);
Route::get('/wards/{district}', [MainController::class, 'getWards']);
Route::post('/logout', [MainController::class, 'logout'])->name('logout');

Route::post('/seller/upload', [MainController::class, 'uploadProduct'])->name('seller.upload');
Route::post('/change-password', [MainController::class, 'changePassword'])->name('changePassword');

//Route::get('/buyer/dashboard', [DashboardController::class, 'index'])->name('buyer.index');
Route::post('/buyer/place-order', [MainController::class, 'store'])->name('buyer.placeOrder');
Route::post('/buyer/cancel-order/{id}', [MainController::class, 'cancelOrder'])->name('buyer.cancelOrder');

Route::put('/products/{id}', [MainController::class, 'update'])->name('products.update');
Route::delete('/products/{id}', [MainController::class, 'destroy'])->name('products.destroy');

Route::post('/seller/edit-product', [MainController::class, 'editProduct'])->name('seller.editProduct');
Route::post('/seller/delete-product', [MainController::class, 'deleteProduct'])->name('seller.deleteProduct');
Route::get('/seller/orders', [MainController::class, 'viewOrders'])->name('seller.orders');
Route::post('/seller/orders/{order}/approve', [MainController::class, 'approveOrder'])->name('seller.approveOrder');

//routes for admin action
Route::post('/admin/delete-user/{id}', [MainController::class, 'deleteUser'])->name('deleteUser');
Route::post('/admin/edit-user', [MainController::class, 'editUser'])->name('editUser');
Route::post('/admin/reset-password', [MainController::class, 'resetPassword'])->name('resetPassword');
// Routes for products
Route::post('/admin/edit-product', [MainController::class, 'editProduct'])->name('admin.editProduct');
Route::post('/admin/delete-product/{id}', [MainController::class, 'deleteProduct'])->name('admin.deleteProduct');
// Routes for orders
Route::post('/admin/orders/edit', [MainController::class, 'editOrder'])->name('admin.editOrder');
Route::post('/admin/orders/delete', [MainController::class, 'deleteOrder'])->name('admin.deleteOrder');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/addseller', [MainController::class, 'addseller'])->name('addseller');
    Route::post('/logout', [MainController::class, 'logout'])->name('logout');
});
