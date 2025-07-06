<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon; // Untuk manipulasi tanggal

class BorrowingController extends Controller
{
    // Metode untuk menampilkan riwayat peminjaman anggota yang sedang login
    public function index()
    {
        // Ambil semua peminjaman untuk user yang sedang login, urutkan berdasarkan tanggal pinjam terbaru
        $borrowings = Borrowing::where('user_id', Auth::id())
                               ->with('book') // Eager load relasi buku
                               ->orderBy('borrow_date', 'desc')
                               ->get();

        return view('borrowings.index', compact('borrowings'));
    }

    // Metode untuk menampilkan formulir peminjaman (jika diperlukan, atau langsung dari detail buku)
    // Untuk saat ini, kita asumsikan peminjaman dilakukan dari halaman detail buku.

    // Metode untuk memproses peminjaman buku baru
    public function borrow(Request $request, Book $book)
    {
        // Pastikan buku tersedia
        if ($book->available_copies <= 0) {
            return back()->with('error', 'Maaf, buku ini sedang tidak tersedia untuk dipinjam.');
        }

        // Cek apakah user sudah meminjam buku ini dan belum mengembalikannya
        $existingBorrowing = Borrowing::where('user_id', Auth::id())
                                      ->where('book_id', $book->id)
                                      ->whereNull('return_date') // Belum dikembalikan
                                      ->first();

        if ($existingBorrowing) {
            return back()->with('error', 'Anda sudah meminjam buku ini dan belum mengembalikannya.');
        }

        // Hitung tanggal jatuh tempo (misal: 7 hari dari sekarang)
        $borrowDate = Carbon::now();
        $dueDate = $borrowDate->copy()->addDays(7);

        // Buat entri peminjaman baru
        Borrowing::create([
            'user_id' => Auth::id(),
            'book_id' => $book->id,
            'borrow_date' => $borrowDate,
            'due_date' => $dueDate,
            'status' => 'borrowed', // Status awal
        ]);

        // Kurangi jumlah salinan tersedia
        $book->decrement('available_copies');

        return back()->with('success', 'Buku berhasil dipinjam! Mohon kembalikan sebelum ' . $dueDate->format('d M Y') . '.');
    }

    // Metode untuk memproses pengembalian buku
    public function returnBook(Borrowing $borrowing)
    {
        // Pastikan peminjaman belum dikembalikan
        if ($borrowing->status === 'returned') {
            return back()->with('error', 'Buku ini sudah dikembalikan sebelumnya.');
        }

        // Update status peminjaman
        $borrowing->update([
            'return_date' => Carbon::now(),
            'status' => 'returned',
        ]);

        // Tambah kembali jumlah salinan tersedia di buku
        $borrowing->book->increment('available_copies');

        return back()->with('success', 'Buku berhasil dikembalikan. Terima kasih!');
    }
}