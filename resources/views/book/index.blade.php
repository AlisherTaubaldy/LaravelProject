<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">

    <div class="row justify-content-center">
        <form action="{{ route('books.search') }}" method="GET" class="mb-6">
            <div class="input-group">
                <select class="form-control mr-2" name="category">
                    <option value="">All Categories</option>
                    @foreach ($categories as $key => $value)
                        <option value="{{ $value }}">{{ $key }}</option>
                    @endforeach
                </select>
                <input type="text" class="form-control" name="search" placeholder="Search books by title or author">
                <button class="btn btn-outline-primary" type="submit">Search</button>
            </div>
        </form>
    </div>

    @if (count($books) > 0)
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach ($books as $book)
                <div class="col">
                    <div class="card">
                        <img src="{{$book->cover}}" class="card-img-top" alt="{{ $book->title }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $book->title }}</h5>
                            <p class="card-text">
                                By {{ $book->author }} <br>
                                Published by {{ $book->publisher }} in {{ $book->published_year }} <br>
                                ISBN: {{ $book->ISBN }}
                                Category: {{$book->category->title}} <br>
                                @if ($book->is_available) <span class="text-success">Book is available</span>
                                @else
                                    <span class="text-danger">Book is not available</span>
                                @endif
                            </p>
                            <div class="row">
                                <form action="{{route('books.rent-book', $book->id)}}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">Rent Book</button>
                                </form>
                                <form action="{{route('books.reserve-book', $book->id)}}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">Reserve Book</button>
                                </form>
                                <form action="{{route('books.book-info', $book->id)}}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">Get Main Info</button>
                                </form>
                            </div>
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
