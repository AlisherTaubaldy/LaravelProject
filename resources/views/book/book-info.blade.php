<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Details</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <h1>{{ $book->title }}</h1>

    <div class="row">
        <div class="col-md-4">
            @if (isset($book->cover))
                <img src="{{ $book->cover }}" alt="{{ $book->title }} cover" class="img-thumbnail">
            @else
                <p>No cover image available.</p>
            @endif
        </div>
        <div class="col-md-8">
            <p>Author: {{ $book->author }}</p>
            <p>Publisher: {{ $book->publisher }}</p>
            <p>Published Year: {{ $book->published_year }}</p>
            <p>ISBN: {{ $book->ISBN }}</p>
            <p>{{ $message }}</p>
        </div>
    </div>

    <h2>Reviews</h2>

    @if (count($reviews) > 0)
        <ul class="list-group">
            @foreach ($reviews as $review)
                <li class="list-group-item">
                    <strong>{{ $review->user->name }}</strong> (Grade: {{ $review->grade }})<br>
                    {{ $review->comment }}<br>
                    <small>Published: {{ $review->publish_date }}</small>
                </li>
            @endforeach
        </ul>
    @else
        <p>No reviews found for this book yet.</p>
    @endif

    <h2>Add a Review</h2>

    @if (Auth::check())  <form action="{{ route('store.review', $book->id) }}" method="POST">
        @csrf <div class="form-group">
            <label for="comment">Your Review:</label>
            <textarea class="form-control @error('comment') is-invalid @enderror" id="comment" name="comment" rows="3"></textarea>
            @error('comment')
            <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="grade">Grade:</label>
            <select class="form-control" id="grade" name="grade">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Submit Review</button>
    </form>
    @else
        <p>Please sign in to add a review.</p>
    @endif

</div>

</body>
</html>
