<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        .hedSet{
            color: blue;
        }
        table,tr,td,th{
            border: 2px solid black;
            text-align: center;
        }
        table{
            border-collapse: collapse;
        }
        th,td{
            padding: 5px;
        }
        th{
            background-color: silver;
        }
        b{
            font-weight: bold;
            font-size: 14px;
        }
        .smallfontsize{
            font-size: 13px;
        }
        ol{
            list-style-type: none;
        }

    </style>
</head>
<body>
    <div class="row" style="font-family: sans-serif;">
        <div class="col-12">
            <h2 class="hedSet">Thanks for your order</h2>
            <h4 >Your order id = {{$order->id}}</h4>
            <h2 class="hedSet">Shipping address</h2>
            <ol class="list-unstyled">
                <li><b class="boldLight">Name:</b> {{$address->first_name}} {{$address->last_name}}</li>
                <li><b class="boldLight">Country:</b> {{$country->name}}</li>
                <li><b class="boldLight">State:</b> {{$address->state}}</li>
                <li><b class="boldLight">City: </b>{{$address->city}}</li>
                @if(!empty($address->apartment))
                    <li><b class="boldLight">Apartment: </b>{{$userAddress->apartment}}</li>
                @endif
                <li><b class="boldLight">Address: </b>{{$address->address}}</li>
                <li><b class="boldLight">Zip Code:</b>{{$country->code}}</li>
                <li><b class="boldLight">Email: </b>{{$address->email}}</li>
                @isset($address->apartment)
            @endisset
            </ol>
        </div>
        <div class="col-12 overflow-scroll">
            <table class="table table-striped mt-2 text-center">
                <caption class="text-center" style="caption-side: top;font-size:20px;font-weight:bold;">Order Items</caption>
                <thead>
                    <tr class="border-0">
                        <th scope="col">Item No</th>
                        <th scope="col">Name</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Single Price</th>
                        <th scope="col">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($orderItems->isNotEmpty())
                        @foreach ($orderItems as $orderItem)
                            @php
                                $orderItemImage=App\Models\productImages::where('products_id',$orderItem->products_id)->first();
                            @endphp
                            <tr class="border-0">
                                <th>{{$orderItem->id}}</th>
                                <td style="text-align: left;">{{$orderItem->name}}</td>
                                <td>{{$orderItem->Quantity}}</td>
                                <td>{{$orderItem->price}}</td>
                                <td>{{$orderItem->total}}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>