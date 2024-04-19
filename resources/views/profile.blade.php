<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookshelf</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            padding-top: 30px;
        }
        .card {
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .card-body {
            padding: 20px;
        }
        .card-title {
            font-weight: bold;
        }
        .card-text {
            margin-bottom: 10px;
        }
        .btn-primary {
            margin-right: 10px;
        }
        .nav-tabs {
            background-color: #f5f5f5;
            border-bottom: 1px solid #ddd;
        }
        .nav-link.active {
            font-weight: bold;
            background-color: #ddd;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>{{$user->name}}</h1>
    <h2>Bookshelf</h2>
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('profile.rented-books') }}">Rented Books</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('profile.reserved-books') }}">Reserved Books</a>
        </li>
    </ul>
    @if (count($books) > 0)
        <div class="row">
            @foreach ($books as $book)
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Title: {{$book->title}}</h5>
                            <p class="card-text">Author: {{$book->author}}</p>
                            <p class="card-text">Category: {{$book->category}}</p>
                            <p class="card-text">Publisher: {{$book->publisher}}</p>
                            <p class="card-text">Published Year: {{$book->published_year}}</p>
                            <p class="card-text">ISBN: {{$book->ISBN}}</p>

                            @if (isset($book->status))
                            <div class="row">
                                <form action="{{route('books.rent-book', $book->id)}}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">Rent Book</button>
                                </form>
                                <form action="{{route('books.cancel-reservation', $book->id)}}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">Cancel Reservation</button>
                                </form>
                            </div>
                            @else
                                <div class="row">
                                    <form action="{{route('books.return-book', $book->id)}}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">Return book</button>
                                    </form>
                                    <form action="{{route('books.extend-rent', $book->id)}}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">Extend Reservation</button>
                                    </form>
                                </div>
                            @endif
                            <p class="card-text">You rented this book: {{$book->rental_date}}</p>
                            <p class="card-text">You should return book until: {{$book->return_date}}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p>No books found.</p>
    @endif
</div>

</body>
</html>
