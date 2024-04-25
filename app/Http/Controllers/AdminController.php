<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookRent;
use App\Models\Category;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function manageUsers()
    {
        $users = User::all();

        return view('admin.manage-users', compact('users'));
    }

    public function addBookPage()
    {
        $category = new Category;

        $categories = $category->getDropdownCategories();

        return view('admin.add-book', compact('categories'));
    }

    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category_id' => 'required|integer',
            'publisher' => 'required|string|max:255',
            'published_year' => 'required|integer',
            'ISBN' => 'required|string|max:255',
            'cover' => 'required|string|max:255',
        ]);

        $book = new Book;
        $book->title = $validatedData['title'];
        $book->author = $validatedData['author'];
        $book->category_id = $validatedData['category_id'];
        $book->cover = $validatedData['cover'];
        $book->publisher = $validatedData['publisher'];
        $book->published_year = $validatedData['published_year'];
        $book->ISBN = $validatedData['ISBN'];

        $book->save();

        $books = Book::all();

        Cache::put('books:all', $books, 60*60);

        return redirect()->route('books.index')->with('success', 'Book added successfully!');
    }

    public function updateUserPage(Request $request, $user_id)
    {
        $user = User::find($user_id);

        return view('admin.update-user', compact('user'));
    }

    public function rentment()
    {
        $rentals = BookRent::orderByRaw('returned_at IS NULL DESC, returned_at DESC')
            ->get();

        foreach ($rentals as $rental){
            $rental->rental_date = Carbon::parse($rental->rental_date)->format('d F y');
            $rental->return_date = Carbon::parse($rental->return_date)->format('d F y');
            $date = Carbon::parse(now())->format('d F y');
            if(is_null($rental->returned_at)){
                if ($rental->return_date < $date){
                    $rental->returned_at = "Rental expired";
                }else{
                    $rental->returned_at = "Not returned yet";
                }
            }else{
                $rental->returned_at = Carbon::parse($rental->returned_at)->format('d F y');
            }
            if(!$rental->extended_at){
                $rental->extended = "Not extended yet";
            }else{
                $rental->extended = "Extended";
            }
        }

        return view('admin.manage-rent', compact('rentals'));
    }
}
