<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    public function bookRents()
    {
        return $this->hasMany(BookRent::class); // 'book_id' (or similar) is the foreign key in BookRent
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class); // 'user_id' is the foreign key in BookRent
    }
}
