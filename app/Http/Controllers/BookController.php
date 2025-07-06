<?php

namespace App\Http\Controllers;

use App\Models\Book; // Import Model Book
use Illuminate\Http\Request;

class BookController extends Controller
{
    // Menampilkan daftar buku untuk publik/anggota yang login (mode baca saja)
    public function indexPublic()
    {
        $books = Book::all(); // Ambil semua buku dari database
        return view('books.index', compact('books')); // View untuk daftar buku publik
    }

    // Menampilkan detail buku untuk publik/anggota yang login (mode baca saja)
    public function showPublic(Book $book)
    {
        return view('books.show', compact('book')); // View untuk detail buku publik
    }
}