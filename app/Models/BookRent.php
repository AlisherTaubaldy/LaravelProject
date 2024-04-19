<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookRent extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class); // 'user_id' is the foreign key in BookRent
    }

    public function book()
    {
        return $this->belongsTo(Book::class); // 'book_id' (or similar) is the primary key in Book
    }
}
