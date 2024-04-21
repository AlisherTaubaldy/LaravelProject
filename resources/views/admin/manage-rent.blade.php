<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Rentals</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evSXbVzTVFTJwvtQveJhxSypQ7gYnGAEYgjFAXvLW0sLwXqZ4qo4zYvbRYiEmVK" crossorigin="anonymous">
</head>
<body>
<div class="container mt-3">
    <h1>Book Rentals</h1>
    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Book</th>
            <th scope="col">User</th>
            <th scope="col">Rental Date</th>
            <th scope="col">Return Date</th>
            <th scope="col">Returned At</th>
            <th scope="col">Extended</th>
            <th scope="col">Extended At</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($rentals as $rental)
            <tr>
                <th scope="row">{{ $rental->id }}</th>
                <td>{{ $rental->book->title ?? 'Book Not Found' }}</td>  <td>{{ $rental->user->name ?? 'User Not Found' }}</td>  <td>{{ $rental->rental_date}}</td>
                <td>{{ $rental->return_date}}</td>
                <td>{{ $rental->returned_at}}</td>
                <td>{{ $rental->extended}}</td>
                <td>{{ $rental->extended_at}}</td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="text-center">No book rentals found.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-OgwbZS7/BXzYhFOT1dPPn4ykCKYN4zV9pE4zGYmWkbNChwyON/vCWqwXaRI2sTX7" crossorigin="anonymous"></script>
</body>
</html>
