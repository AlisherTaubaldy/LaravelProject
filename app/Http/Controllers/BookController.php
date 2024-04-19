<?php

namespace App\Http\Controllers;

use App\Mail\RentMail;
use App\Models\Book;
use App\Models\BookRent;
use App\Models\BookReservement;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $searchQuery = $request->query('search');
        $selectedCategory = $request->query('category'); // New for category search

        $booksQuery = Book::with('category');

        $category = new Category();

        $categories = $category->getDropdownCategories();

        // Filter by category (if selected)
        if ($selectedCategory) {
            $booksQuery = $booksQuery->where('category_id', $selectedCategory);
        }

        // Filter by search query (optional)
        if ($searchQuery) {
            $booksQuery = $booksQuery->where(function ($query) use ($searchQuery) {
                $query->where('title', 'like', '%' . $searchQuery . '%')
                    ->orWhere('author', 'like', '%' . $searchQuery . '%')
                    ->orWhere('ISBN', 'like', '%' . $searchQuery . '%');
            });
        }

        $books = $booksQuery->paginate(15); // Pagination (optional)

        return view('book.index', compact('books', 'searchQuery', 'selectedCategory', 'categories')); // Pass search query to view
    }

    public function search(Request $request)
    {
        // You can handle a dedicated search route if needed (optional)
        return redirect()->route('books.index', ['search' => $request->query('search')]);
    }

    public function getMainInfo(Book $book)
    {
        $reviews = $book->reviews()->with('user')->orderBy('publish_date', 'desc')->paginate(10);

        $message = $this->getAvailabilityDate($book->id);

        foreach ($reviews as $review){
            $review->publish_date = $review->publish_date ? Carbon::parse($review->publish_date)->format('d F Y') : '';
        }

        return view('book.book-info', compact('book', 'reviews', 'message'));
    }

    public function getAvailabilityDate($book_id)
    {
        $book_rent = BookRent::where('book_id', $book_id)
            ->whereNull('returned_at')
            ->first();

        $book_reservement = BookReservement::where('book_id', $book_id)
            ->where('status', 'pending')
            ->first();

        if (!is_null($book_rent)){
            if (!is_null($book_reservement)) {
                return "Book is reserved by someone and will be available: " . $book_reservement->return_date;
            }
            return "Book is rented by someone and will be available: " . $book_rent->return_date;
        }

        if (!is_null($book_reservement)) {
            return "Book is reserved by someone and will be available: " . $book_reservement->return_date;
        }

        return "Book is available now";
    }
}
