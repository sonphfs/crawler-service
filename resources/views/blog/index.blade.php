<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blogs</title>
</head>
<body>
    @foreach($blogs as $key => $blog)
        <h2>{{ $blog->title }} : <span style="color: red"> {{ $blog->tag }}</span> <i>{{ $key }}</i></h2>
        <div>
            <a href="{{$blog->link}}">{{$blog->link}}</a>
        </div>
        <hr>
    @endforeach
</body>
</html>