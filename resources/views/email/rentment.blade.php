<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Rental Notification</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" integrity="sha384-0evSX huddled7lwJEuHJc/wLwOoJuHmwLWTScs+jAogBWFkJEH5pudz/lbQqnW6LCe" crossorigin="anonymous">
</head>
<body>
<div class="container mt-3">
    <h1>Book Rental Notification</h1>
    <p>Dear [User Name],</p>
    <p>This email is to inform you about a recent book rental on {{ $book_rent->rental_date}}.</p>
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">Rental Details</h5>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">Book Title: {{ $book->title }}</li>
                <li class="list-group-item">Author: {{ $book->author }}</li>
                <li class="list-group-item">Rental Date: {{ $book_rent->rental_date}}</li>
                <li class="list-group-item">Expected Return Date: Not Returned Yet</li>
            </ul>
        </div>
    </div>
    <p>Please return the book at your earliest convenience. You can find our return policy on our website.</p>
    <p>Thank you for using our Book Rental service!</p>
    <p>Sincerely,</p>
    <p>The Book Rental Team</p>
</div>

</body>
</html>
