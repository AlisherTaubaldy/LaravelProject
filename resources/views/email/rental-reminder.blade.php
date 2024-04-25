<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upcoming Book Return Reminder</title>
</head>
<body>
<h1>Hi {{ $rentalData['name'] }}</h1>
<p>This is a friendly reminder that your rental of the book (Title: {{ $rentalData['book_title'] }}) is due for return on {{ $rentalData['return_date'] }}.</p>
<p>Thank you for using our library services!</p>
<p>Sincerely,</p>
<p>The Library Team</p>
</body>
</html>
