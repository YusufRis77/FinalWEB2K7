<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Buku - Admin</title>
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
        .form-container { background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); max-width: 600px; margin: 0 auto; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; color: #555; font-weight: bold; }
        input[type="text"], input[type="number"], input[type="file"] { /* Tambahkan input[type="file"] */
            width: calc(100% - 22px);
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="file"] {
            border: none; /* File input biasanya tidak perlu border */
            padding: 0;
        }
        button.submit-btn {
            background-color: #3498DB;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        button.submit-btn:hover { background-color: #2980B9; }
        .back-link { display: inline-block; margin-left: 10px; color: #3498DB; text-decoration: none; }
        .back-link:hover { text-decoration: underline; }
        .error-message { color: red; font-size: 0.8em; margin-top: 5px; }
        .alert { padding: 15px; border-radius: 5px; margin-bottom: 20px; }
        .alert-danger { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
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
                    <li><a href="#">Peminjaman</a></li>
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
        <h1>Edit Buku: {{ $book->title }}</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="form-container">
            <form action="{{ route('admin.buku.update', $book->id) }}" method="POST" enctype="multipart/form-data"> {{-- PENTING: TAMBAHKAN enctype="multipart/form-data" --}}
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="title">Judul Buku:</label>
                    <input type="text" id="title" name="title" value="{{ old('title', $book->title) }}" required>
                    @error('title')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="author">Penulis:</label>
                    <input type="text" id="author" name="author" value="{{ old('author', $book->author) }}" required>
                    @error('author')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="isbn">ISBN:</label>
                    <input type="text" id="isbn" name="isbn" value="{{ old('isbn', $book->isbn) }}" required>
                    @error('isbn')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="publisher">Penerbit (Opsional):</label>
                    <input type="text" id="publisher" name="publisher" value="{{ old('publisher', $book->publisher) }}">
                    @error('publisher')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="publication_year">Tahun Terbit (Opsional):</label>
                    <input type="number" id="publication_year" name="publication_year" value="{{ old('publication_year', $book->publication_year) }}" min="1000" max="{{ date('Y') }}">
                    @error('publication_year')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="category">Kategori:</label>
                    <input type="text" id="category" name="category" value="{{ old('category', $book->category) }}" required>
                    @error('category')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                {{-- INPUT UNTUK GAMBAR SAMPUL --}}
                <div class="form-group">
                    <label for="cover_image">Gambar Sampul (Opsional):</label>
                    @if ($book->cover_image)
                        <div style="margin-bottom: 10px;">
                            <img src="{{ asset('storage/' . $book->cover_image) }}" alt="Sampul Buku" style="max-width: 150px; height: auto; border: 1px solid #ddd; border-radius: 4px;">
                        </div>
                    @endif
                    <input type="file" id="cover_image" name="cover_image" accept="image/*">
                    <small style="color: #666;">Biarkan kosong jika tidak ingin mengubah gambar.</small>
                    @error('cover_image')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                {{-- AKHIR INPUT GAMBAR SAMPUL --}}
                <div class="form-group">
                    <label for="total_copies">Jumlah Eksemplar:</label>
                    <input type="number" id="total_copies" name="total_copies" value="{{ old('total_copies', $book->total_copies) }}" required min="{{ $book->total_copies - $book->available_copies }}">
                    @error('total_copies')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="available_copies">Salinan Tersedia:</label>
                    <input type="number" id="available_copies" name="available_copies" value="{{ old('available_copies', $book->available_copies) }}" required min="0">
                    @error('available_copies')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="submit-btn">Perbarui Buku</button>
                <a href="{{ route('admin.buku.index') }}" class="back-link">Batal</a>
            </form>
        </div>
    </div>
</body>
</html>