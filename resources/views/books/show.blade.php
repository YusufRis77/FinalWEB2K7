<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Buku: {{ $book->title }} - Perpustakaan</title>
    <style>
        body { font-family: sans-serif; background-color: #f0f2f5; margin: 0; padding: 20px; }
        .header { background-color: #2C3E50; color: white; padding: 15px; text-align: center; }
        .header h1 { margin: 0; }
        .nav-buttons { text-align: right; margin-top: 10px; }
        .nav-buttons a, .nav-buttons button {
            background-color: #3498DB;
            color: white;
            padding: 8px 15px;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            margin-left: 10px;
            cursor: pointer;
        }
        .nav-buttons a:hover, .nav-buttons button:hover { background-color: #2980B9; }
        .book-detail { background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); margin-top: 20px; max-width: 600px; margin-left: auto; margin-right: auto; display: flex; flex-wrap: wrap; }
        .book-detail h1 { color: #333; margin-bottom: 15px; width: 100%; }
        .book-detail p { margin-bottom: 8px; color: #555; width: 100%; }
        .book-detail strong { color: #2C3E50; }
        .detail-cover { margin-right: 20px; margin-bottom: 20px; }
        .detail-cover img { max-width: 150px; height: auto; border: 1px solid #ddd; border-radius: 4px; }
        .detail-info { flex-grow: 1; }
        .alert-info { background-color: #d1ecf1; color: #0c5460; border: 1px solid #bee5eb; padding: 10px; border-radius: 4px; margin-bottom: 15px; }
        .alert-error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; padding: 10px; border-radius: 4px; margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Detail Buku</h1>
        <div class="nav-buttons">
            <a href="{{ route('books.index') }}">Kembali ke Daftar Buku</a>
            @auth
                {{-- Link untuk Dashboard Admin jika user adalah admin --}}
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}">Dashboard Admin</a>
                @endif

                {{-- Link Riwayat Peminjaman untuk semua user yang login --}}
                <a href="{{ route('borrowings.index') }}">Riwayat Peminjaman Saya</a>

                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('register') }}">Daftar</a>
            @endauth
        </div>
    </div>

    <div class="book-detail">
        {{-- Tampilkan gambar sampul --}}
        @if ($book->cover_image)
            <div class="detail-cover">
                <img src="{{ asset('storage/' . $book->cover_image) }}" alt="Sampul Buku">
            </div>
        @endif

        <div class="detail-info">
            <h1>{{ $book->title }}</h1>
            <p><strong>Penulis:</strong> {{ $book->author }}</p>
            <p><strong>ISBN:</strong> {{ $book->isbn }}</p>
            <p><strong>Penerbit:</strong> {{ $book->publisher ?? '-' }}</p>
            <p><strong>Tahun Terbit:</strong> {{ $book->publication_year ?? '-' }}</p>
            <p><strong>Kategori:</strong> {{ $book->category }}</p>
            <p><strong>Total Eksemplar:</strong> {{ $book->total_copies }}</p>
            <p><strong>Tersedia:</strong> {{ $book->available_copies }}</p>

         
        </div>
    </div>
</body>
</html>