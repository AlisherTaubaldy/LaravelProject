<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        return redirect()->route('books.index')->with('success', 'Book added successfully!');
    }

    public function updateUser(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255', // Rule for name field
            'email' => 'required|email|max:255', // Rule for email field
            'address' => 'nullable|string|max:255'
        ]);

        $user->update($validatedData);

        return redirect()->route('admin.manage-users')->with('success', 'User updated successfully!');
    }

    public function updateUserPage(Request $request, $user_id)
    {
        $user = User::find($user_id);

        return view('admin.update-user', compact('user'));
    }

    public function deleteUser(User $user)
    {
        $user->delete();

        return redirect()->route('admin.manage-users')->with('success', 'User deleted successfully!');
    }
}
