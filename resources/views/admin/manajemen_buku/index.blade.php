<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Buku - Admin Perpustakaan</title>
    <style>
        body { font-family: sans-serif; margin: 0; background-color: #F8F9FA; display: flex; }
        .sidebar {
            width: 250px;
            background-color: #2C3E50;
            color: white;
            padding: 20px;
            height: 100vh;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .sidebar .logo-container { text-align: center; margin-bottom: 30px; }
        .sidebar .logo-container img { max-width: 100px; height: auto; filter: invert(100%); }
        .sidebar h2 { text-align: center; margin-bottom: 30px; color: #3498DB; }
        .sidebar nav ul { list-style: none; padding: 0; }
        .sidebar nav ul li { margin-bottom: 10px; }
        .sidebar nav ul li a {
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            display: block;
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        .sidebar nav ul li a:hover { background-color: #34495E; }
        .main-content { flex-grow: 1; padding: 20px; width: calc(100% - 250px); }
        .main-content h1 { color: #333; margin-bottom: 20px; }
        .logout-form { margin-top: auto; padding-top: 20px; border-top: 1px solid #444; }
        .logout-form button {
            background-color: #E74C3C;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }
        .logout-form button:hover { background-color: #C0392B; }

        /* Table Styles */
        .table-container { background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table th, table td { border: 1px solid #ddd; padding: 10px; text-align: left; vertical-align: middle; } /* Tambahkan vertical-align */
        table th { background-color: #f2f2f2; }
        .btn {
            padding: 8px 12px;
            border-radius: 4px;
            text-decoration: none;
            color: white;
            cursor: pointer;
            border: none;
        }
        .btn-primary { background-color: #007bff; }
        .btn-primary:hover { background-color: #0056b3; }
        .btn-success { background-color: #28a745; }
        .btn-success:hover { background-color: #218838; }
        .btn-warning { background-color: #ffc107; color: #333; }
        .btn-warning:hover { background-color: #e0a800; }
        .btn-danger { background-color: #dc3545; }
        .btn-danger:hover { background-color: #c82333; }
        .alert { padding: 15px; margin-bottom: 20px; border: 1px solid transparent; border-radius: 4px; }
        .alert-success { color: #155724; background-color: #d4edda; border-color: #c3e6cb; }
        .alert-danger { color: #721c24; background-color: #f8d7da; border-color: #f5c6cb; }
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
        <h1>Manajemen Buku</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="table-container">
            <a href="{{ route('admin.buku.create') }}" class="btn btn-success" style="margin-bottom: 20px;">Tambah Buku Baru</a>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Sampul</th> {{-- KOLOM BARU --}}
                        <th>Judul</th>
                        <th>Penulis</th>
                        <th>ISBN</th>
                        <th>Kategori</th>
                        <th>Total Salinan</th>
                        <th>Salinan Tersedia</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($books as $book)
                        <tr>
                            <td>{{ $book->id }}</td>
                            <td> {{-- SEL UNTUK GAMBAR SAMPUL --}}
                                @if ($book->cover_image)
                                    <img src="{{ asset('storage/' . $book->cover_image) }}" alt="Sampul Buku" style="width: 50px; height: auto; border-radius: 4px;">
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $book->title }}</td>
                            <td>{{ $book->author }}</td>
                            <td>{{ $book->isbn }}</td>
                            <td>{{ $book->category }}</td>
                            <td>{{ $book->total_copies }}</td>
                            <td>{{ $book->available_copies }}</td>
                            <td>
                                <a href="{{ route('admin.buku.edit', $book->id) }}" class="btn btn-warning">Edit</a>
                                <form action="{{ route('admin.buku.destroy', $book->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini?');" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9">Tidak ada buku yang tersedia.</td> {{-- SESUAIKAN COLSPAN --}}
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>