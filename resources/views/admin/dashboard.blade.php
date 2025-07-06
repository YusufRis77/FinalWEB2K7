<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <style>
        body { font-family: sans-serif; margin: 0; background-color: #F8F9FA; display: flex; }
        .sidebar {
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

        /* Gaya untuk statistik */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        .stat-card {
            background-color: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            text-align: center;
        }
        .stat-card h3 {
            margin-top: 0;
            color: #555;
            font-size: 1.1em;
        }
        .stat-card p {
            font-size: 2.5em;
            font-weight: bold;
            color: #3498DB;
            margin: 10px 0 0;
        }
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
                    <li><a href="{{ route('admin.anggota.index') }}">Manajemen Anggota</a></li>
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
        <h1>Selamat Datang di Dashboard Admin!</h1>

        <div class="stats-grid">
            <div class="stat-card">
                <h3>Buku Tersedia</h3>
                <p>{{ $totalAvailableBooks }}</p>
            </div>
            <div class="stat-card">
                <h3>Total Anggota</h3>
                <p>{{ $totalMembers }}</p>
            </div>
            <div class="stat-card">
                <h3>Buku Dipinjam</h3>
                <p>{{ $totalBorrowedBooks }}</p>
            </div>
        </div>

        <p style="margin-top: 30px; color: #666;">Gunakan menu di samping untuk mengelola perpustakaan Anda.</p>
    </div>
</body>
</html>