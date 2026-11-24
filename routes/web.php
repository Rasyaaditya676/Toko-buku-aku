<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;

/*
|--------------------------------------------------------------------------
| Web Routes - Toko Buku Online (PustakaKita)
|--------------------------------------------------------------------------
*/

// Halaman Publik & Informasi
Route::get('/', [StoreController::class, 'landing'])->name('landing');
Route::get('/buku/{book}', [StoreController::class, 'bookDetail'])->name('books.detail');
Route::get('/tentang-kami', [StoreController::class, 'about'])->name('about');
Route::get('/hubungi-kami', [StoreController::class, 'contact'])->name('contact');
Route::post('/hubungi-kami', [StoreController::class, 'sendMessage'])->name('contact.send');

// Autentikasi Pengguna (Tamu / Guest)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Logout (Pengguna Terautentikasi)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Route Khusus Aktor User / Customer
Route::middleware(['auth', 'role:user'])->group(function () {
    // Dashboard & Riwayat Pesanan User
    Route::get('/dashboard', [CheckoutController::class, 'userDashboard'])->name('user.dashboard');
    Route::get('/customer/dashboard', function() {
        return redirect()->route('user.dashboard');
    })->name('customer.dashboard');
    Route::get('/pesanan/{order}', [CheckoutController::class, 'orderDetail'])->name('user.order.detail');

    // Keranjang Belanja (Add to Cart Buku)
    Route::get('/keranjang', [CartController::class, 'index'])->name('cart.index');
    Route::post('/keranjang/tambah/{book}', [CartController::class, 'add'])->name('cart.add');
    Route::put('/keranjang/{cart}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/keranjang/{cart}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/keranjang/kosongkan', [CartController::class, 'clear'])->name('cart.clear');

    // Checkout & Pembayaran (Payment at Delivery / COD)
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
});

// Route Khusus Aktor Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // 1. Dashboard Admin
    Route::get('/', [AdminController::class, 'dashboard']);
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // 2. Add/Update/Delete Kategori Buku
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    // 3. Add/Update/Delete Data Buku
    Route::resource('books', BookController::class);

    // 4. List User yang Sudah Terdaftar
    Route::get('/users', [AdminController::class, 'users'])->name('users.index');

    // 5. List Pesanan Buku dari User yang Berbeda-beda
    Route::get('/orders', [AdminController::class, 'orders'])->name('orders.index');
    Route::get('/orders/{order}', [AdminController::class, 'orderDetail'])->name('orders.show');
    Route::patch('/orders/{order}/status', [AdminController::class, 'updateOrderStatus'])->name('orders.updateStatus');

    // 6. Manajemen Pesan Kontak dari User (Contact to Admin)
    Route::get('/messages', [AdminController::class, 'messages'])->name('messages.index');
    Route::post('/messages/{message}/reply', [AdminController::class, 'replyMessage'])->name('messages.reply');
    Route::patch('/messages/{message}/read', [AdminController::class, 'markMessageRead'])->name('messages.read');
});
