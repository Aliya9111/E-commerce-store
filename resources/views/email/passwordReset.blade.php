<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        li{
            font-size: 13px;
            font-family: sans-serif;
        }
        ul{
            list-style-type: none;
        }

    </style>
</head>
<body>
    <div class="row" style="font-family: sans-serif;">
        <div class="col-12">
            <ul>
                <li>
                    <i>{{$data['email']}}</i>
                </li>
                <li>Please click on the link below and reset password </li>
                <li style="color: blue;"><a style="cursor: pointer;" href="{{route('EmailTokenCheck',$data['token'])}}">{{$data['token']}}</a></li>
            </ul>
        </div>
       
    </div>
</body>
</html>