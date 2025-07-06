<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Buku - Perpustakaan</title>
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

        /* Gaya untuk tampilan GRID */
        .book-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 20px;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-top: 20px;
        }
        .book-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            border: 1px solid #eee;
            padding: 15px;
            border-radius: 8px;
            transition: transform 0.2s;
        }
        .book-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .book-cover {
            width: 120px;
            height: 180px;
            object-fit: cover;
            border-radius: 4px;
            margin-bottom: 10px;
        }
        .book-item-content {
            flex-grow: 1;
            width: 100%;
        }
        .book-item-content h3 {
            margin: 5px 0 8px;
            color: #333;
            font-size: 1.1em;
        }
        .book-item-content h3 a {
            text-decoration: none;
            color: inherit;
        }
        .book-item-content h3 a:hover {
            text-decoration: underline;
        }
        .book-item-content p {
            margin: 0;
            color: #666;
            font-size: 0.85em;
        }
        .no-cover-placeholder {
            width: 120px;
            height: 180px;
            background-color: #e0e0e0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9em;
            color: #777;
            text-align: center;
            border-radius: 4px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Daftar Buku Perpustakaan</h1>
        <div class="nav-buttons">
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

    <div class="book-grid">
        @forelse($books as $book)
            <div class="book-item">
                {{-- Tampilkan gambar sampul --}}
                @if ($book->cover_image)
                    <img src="{{ asset('storage/' . $book->cover_image) }}" alt="Sampul Buku" class="book-cover">
                @else
                    {{-- Placeholder jika tidak ada gambar --}}
                    <div class="no-cover-placeholder">Tidak Ada Sampul</div>
                @endif

                <div class="book-item-content">
                    <h3><a href="{{ route('books.show', $book->id) }}">{{ $book->title }}</a></h3>
                    <p>Penulis: {{ $book->author }}</p>
                    <p>Tersedia: {{ $book->available_copies }}</p>
                </div>
            </div>
        @empty
            <p style="text-align: center; grid-column: 1 / -1;">Belum ada buku tersedia.</p>
        @endforelse
    </div>
</body>
</html>