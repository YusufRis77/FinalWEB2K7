<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Import BelongsTo

class Borrowing extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'borrow_date',
        'due_date',
        'return_date', // nullable
        'status',      // borrowed, returned, overdue
    ];

    // Relasi dengan User (Anggota yang meminjam)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relasi dengan Book (Buku yang dipinjam)
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
}