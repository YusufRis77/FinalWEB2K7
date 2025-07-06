<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Peminjaman Anda - Perpustakaan</title>
    <style>
        body { font-family: sans-serif; margin: 0; background-color: #F8F9FA; padding: 20px; }
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
        .main-content { background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); margin-top: 20px; }
        .main-content h1 { color: #333; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px 15px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #ECF0F1; color: #333; }
        tr:hover { background-color: #f5f5f5; }
        .status-badge { padding: 5px 10px; border-radius: 12px; font-size: 0.8em; color: white; }
        .status-borrowed { background-color: #007bff; }
        .status-returned { background-color: #28a745; }
        .status-overdue { background-color: #dc3545; }
        .action-cell button {
            background-color: #ffc107;
            color: #333;
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .action-cell button:hover { background-color: #e0a800; }
        .alert { padding: 15px; border-radius: 5px; margin-bottom: 20px; }
        .alert-success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Riwayat Peminjaman Anda</h1>
        <div class="nav-buttons">
            <a href="{{ route('books.index') }}">Daftar Buku</a>
            @auth
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}">Dashboard Admin</a>
                @endif
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

    <div class="main-content">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        <table>
            <thead>
                <tr>
                    <th>Sampul</th>
                    <th>Judul Buku</th>
                    <th>Penulis</th>
                    <th>Tanggal Pinjam</th>
                    <th>Jatuh Tempo</th>
                    <th>Tanggal Kembali</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($borrowings as $borrowing)
                    <tr>
                        <td>
                            @if ($borrowing->book->cover_image)
                                <img src="{{ asset('storage/' . $borrowing->book->cover_image) }}" alt="Sampul" style="width: 40px; height: auto; border-radius: 4px;">
                            @else
                                -
                            @endif
                        </td>
                        <td><a href="{{ route('books.show', $borrowing->book->id) }}">{{ $borrowing->book->title }}</a></td>
                        <td>{{ $borrowing->book->author }}</td>
                        <td>{{ \Carbon\Carbon::parse($borrowing->borrow_date)->format('d M Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($borrowing->due_date)->format('d M Y') }}</td>
                        <td>
                            @if ($borrowing->return_date)
                                {{ \Carbon\Carbon::parse($borrowing->return_date)->format('d M Y') }}
                            @else
                                Belum Kembali
                            @endif
                        </td>
                        <td>
                            @php
                                $statusClass = '';
                                $displayStatus = $borrowing->status;
                                if ($borrowing->status === 'borrowed' && \Carbon\Carbon::now()->greaterThan($borrowing->due_date)) {
                                    $statusClass = 'status-overdue';
                                    $displayStatus = 'Terlambat';
                                } elseif ($borrowing->status === 'borrowed') {
                                    $statusClass = 'status-borrowed';
                                } elseif ($borrowing->status === 'returned') {
                                    $statusClass = 'status-returned';
                                }
                            @endphp
                            <span class="status-badge {{ $statusClass }}">{{ $displayStatus }}</span>
                        </td>
                        <td class="action-cell">
                            @if ($borrowing->status === 'borrowed')
                                {{-- Tidak ada tombol "Kembalikan" untuk user, ini hanya untuk admin --}}
                                -
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align: center;">Anda belum memiliki riwayat peminjaman.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>