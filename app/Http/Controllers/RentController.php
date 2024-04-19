<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookRent;
use App\Models\BookReservement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RentController extends Controller
{

    public function index()
    {
        $book_rent = BookRent::all()
            ->orderBy('id', 'desc');

        return view('admin.book_rents', compact('book_rent'));
    }

    public function rentBook(Request $request, $book_id){
        $book = Book::findOrFail($book_id);

        $book_rent = BookRent::where("book_id", $book_id)
            ->first();

        $date = now();
        $date = $date->addDays(7);

        if (!$book->is_available) {
            if (!is_null($book_rent)){
                return response()->json(['message' => "Book is not available, it is rented by someone"], 200);
            }
        }

        $book_reservement = BookReservement::where('book_id', $book_id)
            ->where('status', 'pending')
            ->first();

        if (!is_null($book_reservement)){//если он все же зарезервирован
            if($book_reservement->user_id == Auth::id())//проверка зарезенвирован ли он на него
            {
                $book_reservement->status = 'done';
                $book_reservement->save();
            }else{
                return response()->json(['message' => "Book is reserved by someone"], 200);
            }
        }

        $book_rent = new BookRent();
        $book_rent->book_id = $book->id;
        $book_rent->user_id = Auth::id();
        $book_rent->rental_date = now();
        $book_rent->return_date = $date;
        $book_rent->save();

        $book->is_available = false;
        $book->save();

        return response()->json(['message' => "Book is rented successfully"], 200);
    }

    public function returnBook(Request $request, $book_id)
    {
        // Находим запись об аренде книги
        $book_rent = BookRent::where('book_id', $book_id)
            ->where('user_id', Auth::id())
            ->whereNull('returned_at')
            ->first();

        if(is_null($book_rent)){
            return response()->json(['message' => 'Something went wrong'], 200);
        }
        // Обновляем дату возврата книги
        $book_rent->returned_at = now();
        $book_rent->save();

        // Устанавливаем статус книги как доступной для аренды
        $book = Book::findOrFail($book_id);
        $book->is_available = true;
        $book->save();

        return response()->json(['message' => 'Book returned successfully'], 200);
    }
}
