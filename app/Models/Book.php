<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'isbn',
        'publisher',
        'publication_year',
        'category',
        'total_copies',
        'available_copies',
        'cover_image', // <--- PASTI BARIS INI ADA DI SINI!!!
    ];
}