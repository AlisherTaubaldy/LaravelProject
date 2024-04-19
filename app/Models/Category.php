<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public function getDropdownCategories()
    {
        return Category::pluck('id', 'title');
    }

    public function book()
    {
        return $this->hasMany(Book::class, 'user_id'); // 'user_id' is the foreign key in BookRent
    }
}
