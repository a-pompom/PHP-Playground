{{--ユーザ登録--}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Signup</title>
</head>
<body>
<div>
    @if($errors->any())
        @foreach($errors->all() as $error)
            <p>{{$error}}</p>
        @endforeach
    @endif
</div>
<form action="{{route('signup.post')}}" method="post">
    @csrf
    <input type="text" name="name" placeholder="name">
    <input type="submit" value="signup">
</form>
</body>
</html>
