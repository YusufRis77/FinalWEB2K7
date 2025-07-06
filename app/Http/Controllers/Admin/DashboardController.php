<?php

namespace App\Http\Controllers\Admin; // Pastikan namespace ini benar

use App\Http\Controllers\Controller;
use Illuminate\Http\Request; // Import Request jika dibutuhkan di masa depan
use App\Models\Book; // Import Model Book
use App\Models\User; // Import Model User
use App\Models\Borrowing; // Import Model Borrowing

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung statistik
        $totalAvailableBooks = Book::sum('available_copies'); // Total eksemplar buku yang tersedia
        $totalMembers = User::where('role', 'member')->count(); // Total anggota terdaftar
        $totalBorrowedBooks = Borrowing::where('status', 'borrowed')->count(); // Total buku yang sedang dipinjam

        return view('admin.dashboard', compact('totalAvailableBooks', 'totalMembers', 'totalBorrowedBooks'));
    }
}