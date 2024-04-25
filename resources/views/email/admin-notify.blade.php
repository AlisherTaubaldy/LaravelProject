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
            @if (isset($book->rental_date))
                <p class="card-text">You rented this book: {{$book->rental_date}}</p>
            @else
                <p class="card-text">You need to take this book: {{$book->pickup_date}}</p>
            @endif
            <p class="card-text">You should return book until: {{$book->return_date}}</p>
        </div>
    </div>
</div>
