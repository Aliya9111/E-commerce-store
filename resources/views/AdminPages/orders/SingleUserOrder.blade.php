@extends('AdminPages.layouts.AdminBase')
@section("CustomStyle")
{{--  <link href="{{ asset('Admin/css/BrandProduct.css') }}" rel="stylesheet">   --}}
<style>
    .boldLight,b{
        opacity: 1;
        font-size: 14px;
    }
    td{
        opacity:0.9;
        font-size: 13px
        border-bottom: 0px;
    }
    th{
        opacity:0.9;
    }
    .borderb-Set{
        border-bottom: 2px solid black;
    }
   
</style>
@endsection
@section("title")
  <title>Single Order</title>
@endsection 
@section('MainPart')
    {{--  show the form of Add category etc. --}}
    <div class="row mt-3 ms-3 me-3 gy-2 p-0  justify-content-between">
        <div class="row ms-0 p-0" id="successId">
            <div class="col-12 d-flex p-0" >
                <h3>Single Order:</h3>
                <a href="{{route('AllOrders')}}" class="btn btn-outline-dark ms-3 btn-sm mt-1 mb-1">Back</a>
            </div>
            {{--  show message if the payment status and order status are update  --}}
           
        </div>
         {{--  first part of row  --}}
        <div class="col-md-7 col-12 bg-light shadow-sm" style="font-family: sans-serif;opacity:0.9;font-size:13px">
            <div class="row">
                <div class="col-6 p-3">
                    <h6 style="text-decoration: underline"><b>User Inforamtion</b></h6>
                    <span><b class="boldLight">Name: </b>{{$userAddress->first_name}} {{$userAddress->last_name}}</span>
                    <ol class="list-unstyled d-flex gap-3 mb-0">
                        <li><b class="boldLight">Country:</b> {{$country->name}}</li>
                        <li><b class="boldLight">State:</b> {{$userAddress->state}}</li>
                    </ol>
                    <ol class="list-unstyled">
                        <li><b class="boldLight">City: </b>{{$userAddress->city}}</li>
                        @isset($userAddress->apartment)
                            <li><b class="boldLight">Apartment: </b>{{$userAddress->apartment}}</li>
                        @endisset
                        <li><b class="boldLight">Address: </b>{{$userAddress->address}}</li>
                        <li><b class="boldLight">Zip Code:</b>{{$country->code}}</li>
                        <li><b class="boldLight">Email: </b>{{$userAddress->email}}</li>
                        @isset($userAddress->apartment)
                        <li><b class="boldLight">Note: </b>{{$order->note}}</li>
                    @endisset
                    </ol>

                </div>
                <div class="col-6  p-3">
                    <h6 style="text-decoration: underline"><b>Order Details</b></h6>
                    <span><b class="boldLight">Order No: </b>{{$order->id}}</span>
                    <ol class="list-unstyled">
                        <li><b class="boldLight">Shipping Price: </b>{{$country->amount}}</li>
                        <li><b class="boldLight">Discount: </b>{{$order->discount}}</li>
                        <li><b class="boldLight">Total: </b>{{$order->grand_total}}</li>
                        <li><b class="boldLight">Order Date & time:</b> {{$order->created_at}}</li>
                        @if ($order->Shipped_Date!=null)
                            <li id="shippedId"><b>Shipped Date: </b>{{$order->Shipped_Date}}</li>
                        @endif
                        <li id="shippedId"></li>
                        {{--  payment status  --}}
                        @if ($order->payment_status=='paid')
                            <li><b class="boldLight ">Payment: </b><span class="text-success" id="paymentUpdateId">Paid</span></li>
                        @else
                            <li><b class="boldLight">Payment: </b><span class="text-danger" id="paymentUpdateId">Not Paid</span></li>
                        @endif
                        
                        {{--  order delivered status  --}}
                        @if ($order->status=='pending')
                            <li><b class="boldLight ">Order: </b><span class="text-danger" id="orderUpdateId">Pending</span></li>
                        @elseif ($order->status=='shipped')
                            <li><b class="boldLight">Order: </b><span class="text-primary" id="orderUpdateId">Shipped</span></li>
                        @else
                            <li><b class="boldLight">Order: </b><span class="text-success" id="orderUpdateId">Delivered</span></li>
                        @endif
                    </ol>
                </div>
            </div>

          
        </div>
        {{--  second part of row  --}}
        <div class="col-md-4 col-12">
            <div class="row">
                {{--  payment status part  --}}
                <div class="col-12 bg-light shadow-sm">
                    <label class="form-label mt-3"><b>Payment Status: <i class="fa-solid fa-pen-nib" onclick=updatePaymentStatus(event)></i></b></label>
                    <select class="form-select mb-3" name="payment_status" id="payment_statusId">
                        <option value="paid" {{$order->payment_status=='paid'? 'selected' : ''}}>Paid</option>
                        <option value="not paid" {{$order->payment_status=='not paid'? 'selected' : ''}}>Not Paid</option>
                    </select>
                </div>
                {{--  Order status  --}}
                <div class="col-12 bg-light shadow-sm mt-3">
                    <label class="form-label mt-3"><b>Order Status: <i class="fa-solid fa-pen-nib" onclick=updateOrderStatus(event)></i></b></label>
                    <select class="form-select mb-3" name="status" id="order_statusId" onchange="ShippedDate(event)">
                        <option value="pending" {{$order->status=='pending'? 'selected' : ''}}>Pending</option>
                        <option value="shipped" {{$order->status=='shipped'? 'selected' : ''}}>Shipped</option>
                        <option value="delivered" {{$order->status=='delivered'? 'selected' : ''}}>Delivered</option>
                    </select>
                </div>
                <div class="col-12 bg-light shadow-sm mt-3 p-3 @if($order->status=="shipped") d-block @else d-none @endif" id="shippedInputId">
                    <input type="text" class="form-control" value="{{$order->Shipped_Date}}" name="shippedDate" id="shippedDateAndTime" placeholder="Enter Shipped Date and Time" style="font-size: 13px">
                    <p id="paymentError" class="text-dander" style="font-family: sans-serif;font-size:12px;"></p>
                </div>
                

            </div>
        </div>
        <div class="row p-0 mt-3">
            <div class="col-12 overflow-scroll">
                <table class="table table-striped mt-2 text-center">
                    <caption class="text-center" style="caption-side: top;font-size:20px;font-weight:bold;">Products</caption>
                    <thead>
                        <tr class="border-0">
                            <th scope="col" class="borderb-Set">Item No</th>
                            <th scope="col" class="borderb-Set">Image</th>
                            <th scope="col" class="borderb-Set">Name</th>
                            <th scope="col" class="borderb-Set">Quantity</th>
                            <th scope="col" class="borderb-Set">Single Price</th>
                            <th scope="col" class="borderb-Set">Total</th>
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
                                    <td>
                                        <img src="{{asset('Admin/images/products/uploads/'.$orderItemImage->name)}}" class="img-fluid object-fit-cover" style="height: 50px;width:50px;">
                                    </td>
                                    <td class="text-start">{{$orderItem->name}}</td>
                                    <td>{{$orderItem->Quantity}}</td>
                                    <td>{{$orderItem->price}}</td>
                                    <td>{{$orderItem->total}}</td>

    
                                   
                                    {{--  <td>{{$order->status}}</td>  --}}
                                </tr>
                            @endforeach
                        @endif
                            
                    </tbody>
                </table>
            </div>
        </div>   
    </div>
@endsection

  
@section('CustomAction')
    <script>
        jQuery('#shippedDateAndTime').datetimepicker({});
        function updatePaymentStatus(event){
            jQuery.ajax({
                url: "{{ route('paymentUpdate') }}",
                type:'PUT',
                data:{
                    "orderId":{{$order->id}},
                    "paymentType":jQuery("#payment_statusId").val()
                },
                dataType:'json',
                success:function(response){
                    if(response.status==true){
                        let SuccessIdChilds=document.getElementById("successId").children;
                        {{--  payment  --}}
                        jQuery("#paymentUpdateId").html(response.paymentType);
                        if(response.paymentType=='not paid'){
                            jQuery("#paymentUpdateId").addClass('text-danger');
                            jQuery("#paymentUpdateId").removeClass('text-success');
                        }
                        else{
                            jQuery("#paymentUpdateId").addClass('text-success');
                            jQuery("#paymentUpdateId").removeClass('text-danger');
                        }
                        if(SuccessIdChilds.length==1){
                            let successHtml=`<div class="col-12 mt-2" id="addMessage">
                                <div class="alert alert-success alert-dismissible fade show p-3" role="alert">
                                    <strong>Success!</strong> ${response.message} 
                                </div>
                        </div>
                        `
                        jQuery("#successId").prepend(successHtml);       
                        }
                               
                    }
                }
            });

        }
        function ShippedDate(event){
            if(event.target.value=='shipped'){
                if(jQuery("#shippedInputId").hasClass("d-none")){
                    jQuery("#shippedInputId").removeClass("d-none")
                    jQuery("#shippedInputId").addClass("d-block")
                }
            }
            else{
                if(jQuery("#shippedInputId").hasClass("d-block")){
                    jQuery("#shippedInputId").removeClass("d-block")
                    jQuery("#shippedInputId").addClass("d-none")
                }
            }
        }
        function updateOrderStatus(event){
            jQuery.ajax({
                url: "{{ route('orderUpdate') }}",
                type:'PUT',
                data:{
                    "orderId":{{$order->id}},
                    "orderType":jQuery("#order_statusId").val(),
                    "shippedDate":jQuery("#shippedDateAndTime").val()
                },
                dataType:'json',
                success:function(response){
                    if(response.status==true){
                        let SuccessIdChilds=document.getElementById("successId").children;
                        
                        jQuery("#orderUpdateId").html(response.orderType);
                        if(response.orderType=='pending'){
                            jQuery("#orderUpdateId").addClass('text-danger');
                            jQuery("#orderUpdateId").removeClass('text-success');
                            jQuery("#orderUpdateId").removeClass('text-primary');
                            jQuery("#shippedId").html("");

                        }
                        else if(response.orderType=='shipped'){
                            jQuery("#orderUpdateId").removeClass('text-danger');
                            jQuery("#orderUpdateId").removeClass('text-success');
                            jQuery("#orderUpdateId").addClass('text-primary');
                            jQuery("#shippedId").html("<b>Shipped Date: </b> "+response.shippedDateUpdate)
                        }
                        else{
                            jQuery("#orderUpdateId").removeClass('text-danger');
                            jQuery("#orderUpdateId").addClass('text-success');
                            jQuery("#orderUpdateId").removeClass('text-primary');
                        }
                        if(SuccessIdChilds.length==1){
                            let successHtml=`<div class="col-12 mt-2" id="addMessage">
                                <div class="alert alert-success alert-dismissible fade show p-3" role="alert">
                                    <strong>Success!</strong> ${response.message} 
                                </div>
                        </div>
                        `
                        jQuery("#successId").prepend(successHtml);       
                        }
                        jQuery("#shippedDateAndTime").removeClass("is-invalid");
                        jQuery("#paymentError").html("");
                               
                    }
                    else{
                        jQuery("#shippedDateAndTime").addClass("is-invalid");
                        jQuery("#paymentError").html(response.error);
                    }
                }
            });
        }
    </script>
@endsection