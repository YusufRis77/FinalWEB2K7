<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Peminjaman - Admin</title>
    <style>
        body { font-family: sans-serif; margin: 0; background-color: #F8F9FA; display: flex; }
        .sidebar { /* Gaya sidebar sama dengan dashboard.blade.php */
            width: 250px; background-color: #2C3E50; color: white; padding: 20px; height: 100vh; box-shadow: 2px 0 5px rgba(0,0,0,0.1); display: flex; flex-direction: column; justify-content: space-between; }
        .sidebar .logo-container { text-align: center; margin-bottom: 30px; }
        .sidebar .logo-container img { max-width: 100px; height: auto; filter: invert(100%); }
        .sidebar h2 { text-align: center; margin-bottom: 30px; color: #3498DB; }
        .sidebar nav ul { list-style: none; padding: 0; }
        .sidebar nav ul li { margin-bottom: 10px; }
        .sidebar nav ul li a { color: white; text-decoration: none; padding: 10px 15px; display: block; border-radius: 4px; transition: background-color 0.3s; }
        .sidebar nav ul li a:hover { background-color: #34495E; }
        .logout-form { margin-top: auto; padding-top: 20px; border-top: 1px solid #444; }
        .logout-form button { background-color: #E74C3C; color: white; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer; font-size: 16px; width: 100%; }
        .logout-form button:hover { background-color: #C0392B; }

        .main-content { flex-grow: 1; padding: 20px; }
        .main-content h1 { color: #333; margin-bottom: 20px; }
        .action-buttons { margin-bottom: 20px; text-align: right; }
        .action-buttons a {
            background-color: #28A745; /* Hijau */
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .action-buttons a:hover { background-color: #218838; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; background-color: white; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        th, td { padding: 12px 15px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #ECF0F1; color: #333; }
        tr:hover { background-color: #f5f5f5; }
        .status-badge { padding: 5px 10px; border-radius: 12px; font-size: 0.8em; color: white; }
        .status-borrowed { background-color: #007bff; }
        .status-returned { background-color: #28a745; }
        .status-overdue { background-color: #dc3545; }
        .alert { padding: 15px; border-radius: 5px; margin-bottom: 20px; }
        .alert-success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
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
    </style>
</head>
<body>
    <div class="sidebar">
        <div>
            <div class="logo-container">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Perpustakaan">
            </div>
            <h2>Admin Panel</h2>
            <nav>
    <ul>
        <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li><a href="{{ route('admin.buku.index') }}">Manajemen Buku</a></li>
        {{-- UBAH BARIS INI --}}
        <li><a href="{{ route('admin.anggota.index') }}">Manajemen Anggota</a></li>
        {{-- UBAH BARIS INI --}}
        <li><a href="{{ route('admin.peminjaman.index') }}">Peminjaman</a></li>
    </ul>
</nav>
        </div>
        <div class="logout-form">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit">Logout</button>
            </form>
        </div>
    </div>
    <div class="main-content">
        <h1>Manajemen Peminjaman</h1>

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

        <div class="action-buttons">
            <a href="{{ route('admin.peminjaman.create') }}">Catat Peminjaman Baru</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Anggota</th>
                    <th>Buku</th>
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
                        <td>{{ $borrowing->user->name }}</td>
                        <td><a href="{{ route('books.show', $borrowing->book->id) }}">{{ $borrowing->book->title }}</a></td>
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
                                <form action="{{ route('admin.peminjaman.return', $borrowing->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin buku ini sudah dikembalikan?');">
                                    @csrf
                                    <button type="submit">Kembalikan</button>
                                </form>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center;">Belum ada riwayat peminjaman.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>