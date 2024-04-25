<?php

namespace App\Http\Controllers;

use App\Mail\AdminMail;
use App\Models\Book;
use App\Models\BookRent;
use App\Models\BookReservement;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ReserveController extends Controller
{
    public function index()
    {
        $book_reservements = BookReservement::all()
            ->orderBy('id', 'desc');

        return view('admin.book_reservements', compact('book_reservements'));
    }

    public function reserveBook(Request $request, $book_id)
    {
        $book = Book::findOrFail($book_id);

        $id = Auth::id();

        $date = now();
        $date = $date->addDays(3);

        $book_reservement = BookReservement::where('book_id', $book_id)
            ->where('status', 'pending')
            ->first();

        $book_rent = BookRent::where('book_id', $book_id)
            ->whereNull('returned_at')
            ->first();

        if (!is_null($book_reservement)) {
            return response()->json(['message' => 'Book is not available for reserve'], 403);
        }

        $book_reservement = new BookReservement();
        $book_reservement->book_id = $book->id;
        $book_reservement->user_id = Auth::id();
        $book_reservement->reservation_date = now();

        if (!is_null($book_rent))
        {
            if ($book_rent->user_id == $id){
                return response()->json(['message' => 'Sorry, but you already rented this book and cant reserve it again, Try to extend rentment'], 200);
            }
            $date_obj = Carbon::parse($book_rent['return_date']);
            $book_reservement->pickup_date = $book_rent->return_date;
            $book_reservement->return_date = $date_obj->addDays(7);
        }else{
            $book_reservement->pickup_date = $date;
            $book_reservement->return_date = $date->addDays(7);
        }

        $book_reservement->save();

        $book->is_available = false;

        Mail::to('shuketsumurano@gmail.com')->send(new AdminMail($book));

        $book->save();

        return response()->json(['message' => 'Book reserved successfully \n please take it in 3 days'], 200);
    }

    public function cancelReservation(Request $request, $book_id)
    {
        $book_reservement = BookReservement::where('book_id', $book_id)
            ->where('user_id', Auth::id())
            ->where('status', 'pending')
            ->firstOrFail();

        $book_reservement->status = 'done';
        $book_reservement->save();

        // Устанавливаем статус книги как доступной для аренды
        $book = Book::findOrFail($book_id);
        $book->is_available = true;
        $book->save();

        return response()->json(['message' => 'Book reservation canceled successfully'], 200);
    }
}
