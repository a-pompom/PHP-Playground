{{--作成--}}
    <!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>Tweet Create</title>
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

<form method="post" action="{{route('crud.create.create')}}">
    @csrf
    <label for="contents">Contents</label>
    <input
        id="contents"
        type="text"
        name="contents"
    >

    <input type="submit" value="Create">
</form>
</body>
</html>
