<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Book</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1>Add New Book</h1>
    <form action="{{ route('admin.add-book') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="Enter book title">
        </div>
        <div class="form-group">
            <label for="author">Author:</label>
            <input type="text" class="form-control" id="author" name="author" placeholder="Enter book author">
        </div>
        <div class="form-group">
            <label for="category_id">Category:</label>
            <select class="form-control" id="category_id" name="category_id">
                <option value="">Select Category</option>
                @foreach ($categories as $key => $value)
                    <option value="{{ $value }}">{{ $key }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="publisher">Publisher:</label>
            <input type="text" class="form-control" id="publisher" name="publisher" placeholder="Enter book publisher">
        </div>
        <div class="form-group">
            <label for="published_year">Published Year:</label>
            <input type="number" class="form-control" id="published_year" name="published_year" placeholder="Enter published year">
        </div>
        <div class="form-group">
            <label for="ISBN">ISBN:</label>
            <input type="text" class="form-control" id="ISBN" name="ISBN" placeholder="Enter ISBN number">
        </div>
        <div class="form-group">
            <label for="cover">Book Cover:</label>
            <input type="text" class="form-control" id="cover" name="cover" placeholder="Enter cover image link">
        </div>
        <button type="submit" class="btn btn-primary">Add Book</button>
    </form>
</div>
</body>
</html>
