<?php

namespace App\Http\Controllers;

use App\Models\BookRent;
use App\Models\BookReservement;
use App\Models\Category;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function rentedBooks()
    {
        $user_id = Auth::id(); // Assuming you have a method to retrieve the authenticated user
        $user = Auth::user(); // Assuming you have a method to retrieve the authenticated user

        $books = DB::table('book_rents')
            ->where('user_id', $user_id)
            ->whereNull('returned_at')
            ->join('books', 'book_rents.book_id', '=', 'books.id')
            ->select('books.*', 'book_rents.rental_date', 'book_rents.return_date', 'book_rents.returned_at')
            ->get();

        foreach ($books as $book){
            $category = Category::find($book->category_id);

            $book->category = $category->title;
        }

        return view("profile", compact('books', 'user'));
    }

    public function reservedBooks()
    {
        $user_id = Auth::id();
        $user = Auth::user();

        $books = DB::table('book_reservements')
            ->where('user_id', $user_id)
            ->where('status', 'pending')
            ->join('books', 'book_reservements.book_id', '=', 'books.id')
            ->select('books.*', 'book_reservements.pickup_date', 'book_reservements.return_date', 'book_reservements.status')
            ->get();

        foreach ($books as $book){
            $category = Category::find($book->category_id);

            $book->category = $category->title;
        }

        return view("profile", compact('books', 'user'));
    }

    public function extendRentment($book_id)
    {
        $id = Auth::id();

        $book_reservement = BookReservement::where('book_id', $book_id)
            ->where('status', 'pending')
            ->where('user_id', $id)
            ->first();

        if (!is_null($book_reservement)){
            return response()->json(['message' => 'Book is reserved by someone'], 200);
        }

        $book_rent = BookRent::where('book_id', $book_id)
            ->whereNull('returned_at')
            ->where('user_id', $id)
            ->first();

        $book_rent->extended = 1;
        $book_rent->return_date = Carbon::parse($book_rent->return_date)->addDays(7);
        $book_rent->extended_at = now();
        $book_rent->save();

        return response()->json(['message' => 'Book rent extended for 7 days'], 200);
    }
}
