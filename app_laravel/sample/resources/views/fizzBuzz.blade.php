<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>FizzBuzz</title>
</head>
<h1>FizzBuzz</h1>

@for($i=1; $i<=$count;$i++)
    @if($i % 15 === 0)
        <p>FizzBuzz!!</p>
    @elseif($i % 3 === 0)
        <p>Fizz</p>
    @elseif($i % 5 === 0)
        <p>Buzz</p>
    @else
        <p>{{$i}}</p>
    @endif
@endfor
</html>
