{{--一覧--}}
    <!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Tweet List</title>
</head>
<body>
<a href="{{route('crud.create')}}">
    <button type="button">Add</button>
</a>
<ul>
    @foreach($tweets as $tweet)
        <li>
            {{$tweet->contents}}
            <a href="{{route('crud.update.index', ['tweetId' => $tweet->id])}}">
                <button type="button">Update</button>
            </a>
            <form method="post" action="{{route('crud.delete', ['tweetId' => $tweet->id])}}">
                @csrf
                <input type="submit" value="Delete">
            </form>
        </li>
    @endforeach
</ul>
</body>
</html>
