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
        ol{
            list-style-type: none;
        }

    </style>
</head>
<body>
    <div class="row" style="font-family: sans-serif;">
        <div class="col-12">
            <ol>
                <li>{{$userMessageRecord->name}}</li>
                <li>{{$userMessageRecord->email}}</li>
                <li>{{$userMessageRecord->message}}</li>
            </ol>
        </div>
       
    </div>
</body>
</html>