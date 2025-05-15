<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
       .textSet{
           font-size:13px;
           opacity: 0.9;
           font-family: sans-serif;
       }
      
    </style>
</head>
<body>
    <div>
        <p class="textSet" style="background-image: rgb(115, 115, 235);padding:20px; border:2px solid;blue;background-clip:padding-box;">
            <h2>Your Question</h2>
            {{$question}}
        </p>
    </div>
    <div>
        <h2>Response</h2>
        {!! $response !!}
    </div>
</body>
</html>