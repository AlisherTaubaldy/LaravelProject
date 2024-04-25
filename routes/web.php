<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RentController;
use App\Http\Controllers\ReserveController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\IsAdmin;
use App\Mail\RentMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// Register
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/books', [BookController::class, 'show'])->name('books.index');
    // Optional dedicated search route (if desired)
    Route::get('/books/search', [BookController::class, 'index'])->name('books.search');

    Route::get('/profile', [ProfileController::class, 'rentedBooks'])->name('profile');

    Route::get('/profile/rented-books', [ProfileController::class, 'rentedBooks'])->name('profile.rented-books');
    Route::get('/profile/reserved-books', [ProfileController::class, 'reservedBooks'])->name('profile.reserved-books');


    Route::post('/books/rent-book/{book_id}', [RentController::class, 'rentBook'])->name('books.rent-book');
    Route::post('/books/return-book/{book_id}', [RentController::class, 'returnBook'])->name('books.return-book');
    Route::post('/books/reserve-book/{book_id}', [ReserveController::class, 'reserveBook'])->name('books.reserve-book');
    Route::post('/books/cancel-reservation/{book_id}', [ReserveController::class, 'cancelReservation'])->name('books.cancel-reservation');

    Route::get('/profile/password/email', [ForgotPasswordController::class, 'getEmail'])->name('password.email');
    Route::post('/profile/password/request', [ForgotPasswordController::class, 'postEmail'])->name('password.request');
    Route::get('/profile/password/reset/{token}', [ResetPasswordController::class, 'getForm'])->name('password.reset');
    Route::post('/profile/password/reset', [ResetPasswordController::class, 'postReset'])->name('password.update');

    Route::post('/profile/update-user/{user}', [ProfileController::class, 'updatePage'])->name('profile.update');
    Route::put('/profile/update-user/{user}', [UserController::class, 'update'])->name('profile.update');


    Route::post('/books/extend-rent/{book_id}', [ProfileController::class, 'extendRentment'])->name('books.extend-rent');

    Route::post('/books/book-info/{book}', [BookController::class, 'getMainInfo'])->name('books.book-info');
    Route::get('/books/book-info/{book}', [BookController::class, 'getMainInfo'])->name('books.book-info');

    Route::get('/testroute', [ForgotPasswordController::class, 'getEmail']);

    Route::post('/review/store/{book_id}', [ReviewController::class, 'store'])->name('store.review');
});

Route::middleware(IsAdmin::class)->group(function (){
    Route::get('/admin', [AdminController::class, 'index'])->name('admin');
    Route::get('/admin/book-rents', [AdminController::class, 'rentment'])->name('admin.manage-rent');

    Route::get('/admin/manage-users', [AdminController::class, 'manageUsers'])->name('admin.manage-users');

    Route::get('/admin/manage-users/update-user/{user_id}', [AdminController::class, 'updateUserPage'])->name('admin.manage-users.update');
    Route::put('/admin/manage-users/update-user/{user}', [UserController::class, 'update'])->name('admin.manage-users.update-user');
    Route::delete('/admin/manage-users/delete-user/{user}', [UserController::class, 'delete'])->name('admin.manage-users.delete');

    Route::get('/admin/add-book', [AdminController::class, 'addBookPage'])->name('admin.add-book');
    Route::post('/admin/add-book', [AdminController::class, 'create'])->name('admin.create');
});
