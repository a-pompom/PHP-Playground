{{--更新--}}
    <!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Tweet Update</title>
</head>
<body>
<a href="{{route('crud.index')}}">
    <button type="button">Index</button>
</a>
<div>
    @if($errors->any())
        @foreach($errors->all() as $error)
            <p>{{$error}}</p>
        @endforeach
    @endif
</div>
<form method="post" action="{{route('crud.update.update', ['tweetId' => $tweet->id])}}">
    @csrf
    <label for="contents">Contents</label>
    <input
        id="contents"
        type="text"
        name="contents"
        value="{{$tweet->contents}}"
    >

    <input type="submit" value="Update">
</form>
</body>
</html>
