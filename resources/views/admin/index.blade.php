<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1>Admin Panel</h1>

    <a href="{{ route('admin.manage-users') }}" class="btn btn-primary">Manage Users</a>
    <a href="{{ route('admin.add-book') }}" class="btn btn-primary">Add Book</a>

    <div class="content">
    </div>
</div>
</body>
</html>

