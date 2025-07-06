<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catat Peminjaman Baru - Admin</title>
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
        .form-container { background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); max-width: 600px; margin: 0 auto; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; color: #555; font-weight: bold; }
        input[type="date"], select {
            width: calc(100% - 22px);
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button.submit-btn {
            background-color: #28A745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        button.submit-btn:hover { background-color: #218838; }
        .back-link { display: inline-block; margin-left: 10px; color: #3498DB; text-decoration: none; }
        .back-link:hover { text-decoration: underline; }
        .error-message { color: red; font-size: 0.8em; margin-top: 5px; }
        .alert { padding: 15px; border-radius: 5px; margin-bottom: 20px; }
        .alert-success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
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
                    <li><a href="#">Manajemen Anggota</a></li>
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
        <h1>Catat Peminjaman Baru</h1>

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
        @if ($errors->any())
            <div class="alert alert-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="form-container">
            <form action="{{ route('admin.peminjaman.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="user_id">Anggota:</label>
                    <select id="user_id" name="user_id" required>
                        <option value="">Pilih Anggota</option>
                        @foreach ($members as $member)
                            <option value="{{ $member->id }}" {{ old('user_id') == $member->id ? 'selected' : '' }}>
                                {{ $member->name }} ({{ $member->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="book_id">Buku:</label>
                    <select id="book_id" name="book_id" required>
                        <option value="">Pilih Buku</option>
                        @foreach ($books as $book)
                            <option value="{{ $book->id }}" {{ old('book_id') == $book->id ? 'selected' : '' }}>
                                {{ $book->title }} oleh {{ $book->author }} (Tersedia: {{ $book->available_copies }})
                            </option>
                        @endforeach
                    </select>
                    @error('book_id')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="borrow_date">Tanggal Peminjaman:</label>
                    <input type="date" id="borrow_date" name="borrow_date" value="{{ old('borrow_date', date('Y-m-d')) }}" required>
                    @error('borrow_date')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="due_date">Tanggal Jatuh Tempo:</label>
                    <input type="date" id="due_date" name="due_date" value="{{ old('due_date', \Carbon\Carbon::now()->addDays(7)->format('Y-m-d')) }}" required>
                    @error('due_date')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="submit-btn">Catat Peminjaman</button>
                <a href="{{ route('admin.peminjaman.index') }}" class="back-link">Batal</a>
            </form>
        </div>
    </div>
</body>
</html>