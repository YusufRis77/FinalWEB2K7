<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use App\Models\Book;
use App\Models\User; // Untuk daftar anggota
use Illuminate\Http\Request;
use Carbon\Carbon; // Untuk manipulasi tanggal

class AdminBorrowingController extends Controller
{
    // Menampilkan daftar semua peminjaman (aktif dan riwayat) untuk admin
    public function index()
    {
        $borrowings = Borrowing::with(['user', 'book']) // Eager load relasi user dan book
                               ->orderBy('status', 'asc') // Urutkan status (borrowed di atas)
                               ->orderBy('due_date', 'asc') // Lalu urutkan berdasarkan jatuh tempo
                               ->get();

        return view('admin.peminjaman.index', compact('borrowings'));
    }

    // Menampilkan formulir untuk mencatat peminjaman baru
    public function create()
    {
        $books = Book::where('available_copies', '>', 0)->orderBy('title')->get(); // Buku yang tersedia
        $members = User::where('role', 'member')->orderBy('name')->get(); // Anggota
        
        return view('admin.peminjaman.create', compact('books', 'members'));
    }

    // Memproses pencatatan peminjaman baru dari admin
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'borrow_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:borrow_date',
        ]);

        $book = Book::findOrFail($request->book_id);

        if ($book->available_copies <= 0) {
            return redirect()->route('admin.peminjaman.create')->with('error', 'Maaf, buku ini sedang tidak tersedia untuk dipinjam.');
        }
        
        // Cek apakah user sudah meminjam buku ini dan belum mengembalikannya
        $existingBorrowing = Borrowing::where('user_id', $request->user_id)
                                      ->where('book_id', $request->book_id)
                                      ->whereNull('return_date') // Belum dikembalikan
                                      ->first();

        if ($existingBorrowing) {
            return redirect()->route('admin.peminjaman.create')->with('error', 'Anggota ini sudah meminjam buku yang sama dan belum mengembalikannya.');
        }


        Borrowing::create([
            'user_id' => $request->user_id,
            'book_id' => $request->book_id,
            'borrow_date' => $request->borrow_date,
            'due_date' => $request->due_date,
            'status' => 'borrowed',
        ]);

        $book->decrement('available_copies');

        return redirect()->route('admin.peminjaman.index')->with('success', 'Peminjaman berhasil dicatat!');
    }

    // Memproses pengembalian buku dari admin
    public function returnBook(int $borrowing_id) // Menerima ID peminjaman
    {
        $borrowing = Borrowing::findOrFail($borrowing_id);

        if ($borrowing->status === 'returned') {
            return redirect()->route('admin.peminjaman.index')->with('error', 'Buku ini sudah dikembalikan sebelumnya.');
        }
        
        $borrowing->update([
            'return_date' => Carbon::now(),
            'status' => 'returned',
        ]);

        $borrowing->book->increment('available_copies');

        return redirect()->route('admin.peminjaman.index')->with('success', 'Buku berhasil dikembalikan. Terima kasih!');
    }

    // Opsional: Metode untuk mengedit detail peminjaman (jika diperlukan)
    // public function edit(int $borrowing_id) { ... }
    // public function update(Request $request, int $borrowing_id) { ... }
    // public function destroy(int $borrowing_id) { ... }
}