<?php

use Illuminate\Support\Facades\Route;

// Import Controller cho Admin
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController; 
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ReviewController;

// Import Controller cho Client
use App\Http\Controllers\Client\AccountController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\AuthController;
use App\Http\Controllers\Client\OrderController;
use App\Http\Controllers\Client\ProductController as ClientProductController;
use App\Http\Controllers\Client\ChatController; 
use App\Http\Controllers\Client\ForgotPasswordController;
use App\Http\Controllers\Client\NewsletterController;

/*
|--------------------------------------------------------------------------
| TUYẾN ĐƯỜNG CLIENT (FRONT-END)
|--------------------------------------------------------------------------
*/

// --- Các trang công khai ---
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/cua-hang', [ClientProductController::class, 'index'])->name('client.shop');
Route::get('/san-pham/{slug}', [ClientProductController::class, 'detail'])->name('client.product.detail');
Route::post('/san-pham/{productId}/review', [ClientProductController::class, 'storeReview'])->name('reviews.store');
// --- Trang sale ---
Route::get('/khuyen-mai', [ClientProductController::class, 'sale'])->name('client.sale');
// -- Trang hướng dẫn mua hàng ---
Route::view('/huong-dan-mua-hang', 'client.pages.shopping_guide')->name('client.shopping_guide');
Route::view('/chinh-sach-bao-hanh', 'client.pages.warranty_policy')->name('client.warranty_policy');
Route::view('/phuong-thuc-thanh-toan', 'client.pages.payment_methods')->name('client.payment_methods');
Route::view('/van-chuyen-giao-nhan', 'client.pages.shipping_policy')->name('client.shipping_policy');
Route::post('/dang-ky-nhan-tin', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');
// --- (MỚI) Route cho Chatbot AI ---
Route::post('/chat-ai', [ChatController::class, 'sendMessage'])->name('chat.send');

// --- Giỏ hàng ---
Route::prefix('gio-hang')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/them/{id}', [CartController::class, 'add'])->name('add');
    Route::post('/cap-nhat', [CartController::class, 'update'])->name('update');
    Route::get('/xoa/{id}', [CartController::class, 'remove'])->name('remove');
});

// --- Xác thực ---
Route::get('/dang-ky', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/dang-ky', [AuthController::class, 'register']);
Route::get('/dang-nhap', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/dang-nhap', [AuthController::class, 'login']);
Route::post('/dang-xuat', [AuthController::class, 'logout'])->name('logout');
// --- Quên mật khẩu ---
Route::get('quen-mat-khau', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('quen-mat-khau', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('dat-lai-mat-khau/{token}/{email}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('dat-lai-mat-khau', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');

// --- Các trang yêu cầu đăng nhập ---
Route::middleware(['auth'])->group(function () {
    // Thanh toán
    Route::get('/thanh-toan', [OrderController::class, 'index'])->name('checkout.index');
    Route::post('/thanh-toan', [OrderController::class, 'store'])->name('checkout.store');
    Route::get('/dat-hang-thanh-cong', [OrderController::class, 'success'])->name('checkout.success');
    Route::get('/thanh-toan/ngan-hang/{orderId}', [OrderController::class, 'showPaymentQr'])->name('checkout.payment');
    Route::post('/thanh-toan/ngan-hang/{orderId}/xac-nhan', [OrderController::class, 'confirmPayment'])->name('checkout.confirm_payment');
    // Lịch sử đơn hàng & Tài khoản
    Route::get('/don-hang-cua-toi', [OrderController::class, 'history'])->name('client.orders.index');
    Route::get('/don-hang-cua-toi/{id}', [OrderController::class, 'detail'])->name('client.orders.show');
    Route::get('/tai-khoan', [AccountController::class, 'index'])->name('client.account.index');
    Route::post('/tai-khoan/cap-nhat-thong-tin', [AccountController::class, 'updateProfile'])->name('client.account.update_profile');
    Route::post('/tai-khoan/doi-mat-khau', [AccountController::class, 'updatePassword'])->name('client.account.update_password');
});

/*
|--------------------------------------------------------------------------
| TUYẾN ĐƯỜNG ADMIN (BACK-END)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('categories', CategoryController::class);
    Route::resource('brands', BrandController::class);
    Route::resource('products', ProductController::class);
    
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{id}', [AdminOrderController::class, 'updateStatus'])->name('orders.update_status');

    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/customers/{id}', [CustomerController::class, 'show'])->name('customers.show'); 
    Route::delete('/customers/{id}', [CustomerController::class, 'destroy'])->name('customers.destroy'); 
    
    Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
});