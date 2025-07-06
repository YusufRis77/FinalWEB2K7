<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController; // Untuk tampilan buku publik
use App\Http\Controllers\AdminBookController; // Untuk manajemen buku admin
use App\Http\Controllers\BorrowingController; // Untuk riwayat peminjaman anggota
use App\Http\Controllers\Admin\AdminBorrowingController; // Untuk manajemen peminjaman admin
use App\Http\Controllers\Admin\AdminMemberController; // Untuk manajemen anggota admin
use App\Http\Controllers\Admin\DashboardController; // <-- PENTING: Import DashboardController
use Illuminate\Support\Facades\Route;

// Rute Public / Auth
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Halaman Utama / Daftar Buku Public (bisa diakses siapa saja)
Route::get('/', function () {
    return redirect()->route('books.index');
});

Route::get('/books', [BookController::class, 'indexPublic'])->name('books.index');
Route::get('/books/{book}', [BookController::class, 'showPublic'])->name('books.show');

// Rute yang memerlukan autentikasi (untuk Anggota dan Admin)
Route::middleware(['auth'])->group(function () {
    // Rute untuk melihat riwayat peminjaman (oleh anggota)
    Route::get('/my-borrowings', [BorrowingController::class, 'index'])->name('borrowings.index');
});


// Rute Admin (dilindungi oleh middleware 'auth' dan 'admin')
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    // UBAH BARIS INI: Sekarang menunjuk ke DashboardController
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Rute untuk Manajemen Buku (CRUD) - Menggunakan nama 'buku'
    Route::get('buku', [AdminBookController::class, 'index'])->name('admin.buku.index');
    Route::get('buku/create', [AdminBookController::class, 'create'])->name('admin.buku.create');
    Route::post('buku', [AdminBookController::class, 'store'])->name('admin.buku.store');
    Route::get('buku/{buku}', [AdminBookController::class, 'show'])->name('admin.buku.show');
    Route::get('buku/{buku}/edit', [AdminBookController::class, 'edit'])->name('admin.buku.edit');
    Route::put('buku/{buku}', [AdminBookController::class, 'update'])->name('admin.buku.update');
    Route::delete('buku/{buku}', [AdminBookController::class, 'destroy'])->name('admin.buku.destroy');

    // Rute untuk Manajemen Peminjaman Admin
    Route::get('peminjaman', [AdminBorrowingController::class, 'index'])->name('admin.peminjaman.index');
    Route::get('peminjaman/create', [AdminBorrowingController::class, 'create'])->name('admin.peminjaman.create');
    Route::post('peminjaman', [AdminBorrowingController::class, 'store'])->name('admin.peminjaman.store');
    Route::post('peminjaman/return/{borrowing_id}', [AdminBorrowingController::class, 'returnBook'])->name('admin.peminjaman.return');

    // Rute untuk Manajemen Anggota Admin
    Route::get('anggota', [AdminMemberController::class, 'index'])->name('admin.anggota.index');
    Route::get('anggota/{anggota}/edit', [AdminMemberController::class, 'edit'])->name('admin.anggota.edit');
    Route::put('anggota/{anggota}', [AdminMemberController::class, 'update'])->name('admin.anggota.update');
    Route::delete('anggota/{anggota}', [AdminMemberController::class, 'destroy'])->name('admin.anggota.destroy');
});