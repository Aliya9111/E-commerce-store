@extends("AllUsersPages.layouts.topBar")
@section("UserStyleSheet")
    <link href="{{asset('AllUsers/css/profileCart.css')}}" rel="stylesheet">
@show
@section('timeName','Cart')
@section('cartCodeHide')
<div class="text-end d-lg-none d-flex order-2">
    <ul class="list-unstyled d-inline-flex gapSet mb-0">
        <li class="fs-1 shopping">
            <button type="button" class="btn position-relative " onclick="window.location.href='{{route('CartPage.index')}}'">
                <i class="fa-solid fa-cart-shopping" style="color: rgb(53, 83, 231)"></i>
                <span class="position-absolute top-0 start-90 translate-middle badge rounded-pill bg-danger TotalProductsCount" style="height:fit-content;width:fit-content">
                
                    {{count(Cart::Session(Auth::id())->getContent())}}
                    {{--  <span class="visually-hidden">unread messages</span>  --}}
                </span>
            </button>
        </li>
    </ul>
</div>

@endsection
@section('cartCodeShow')
<div class="col-3 d-lg-inline d-none" id="cartAddNumberShow">
    <div class="text-end d-flex">
        <ul class="list-unstyled d-inline-flex gapSet mb-0 ms-auto">
            <li class="fs-1 shopping">
                <button type="button" class="btn position-relative " onclick="window.location.href='{{route('CartPage.index')}}'">
                    <i class="fa-solid fa-cart-shopping" style="color: rgb(53, 83, 231)"></i>
                    <span class="position-absolute top-0 start-90 translate-middle badge rounded-pill bg-danger TotalProductsCount" style="height:fit-content;width:fit-content">
                        {{count(Cart::Session(Auth::id())->getContent())}}
                        {{--  <span class="visually-hidden">unread messages</span>  --}}
                    </span>
                </button>
            </li>
        </ul>
    </div>
</div>
@endsection
@section('row 2')
<div class="row mb-3 ms-lg-4 ms-sm-2 ms-1 me-lg-4 me-sm-2 me-1" style="margin-top:10px; ">
    <div class="col-12 border" style="background-color: rgb(243, 243, 243);">
        <nav aria-label="breadcrumb" class="" style="transform: translateY(5px)">
            <ol class="breadcrumb bg-transparent">
                <li class="breadcrumb-item"><a href="{{asset(route('Home'))}}" class="">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Cart</li>
            </ol>
        </nav>
    </div>
</div>
@endsection

@section('row 3')
    @if ($productsLength>0)
        <div class="row mb-3 ms-lg-4 ms-sm-2 ms-1 me-lg-4 me-sm-2 me-1 d-flex CommonLighColor justify-content-lg-evenly justify-content-center" id="cartNotEmpty">
            <div class="col-lg-7 col-md-6 col-12" style="overflow-x: scroll" id="cartDataTable">
                <table class="mt-4 tableCart" id="tableCartId">
                    <header>
                        <tr>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Total Price</th>
                            <th>Action</th>
                        </tr>
                    </header>    
                    <tbody id="tbodyData">
                        @php
                            $CartProducts=Cart::Session(Auth::id())->getContent();
                        @endphp
                        @foreach ($CartProducts as $CartProduct)
                            @php
                                $productsId=App\Models\products::where('id',$CartProduct->id)->value('price');
                            @endphp
                            <tr class="trback" id="del-{{$CartProduct->id}}">
                                <td class=""><img src="{{asset('Admin/images/products/uploads/'.$CartProduct->attributes->productImage)}}" class="img-flud" style="max-height:50px;max-width:60px;" alt=""></td>
                                <td style="text-align:left">{{$CartProduct->name}}</td>
                                <td>
                                    <div class="d-flex text-center justify-content-center">
                                        <div class="btn btn-primary productIncDec" onclick=IncreaseProduct(event,{{$CartProduct->id}},{{$CartProduct->attributes->ProductQuantity}})>+</div>
                                        <div class="align-content-center ps-2 pe-2" style="font-size: 13px;font-weight:bold">{{$CartProduct->quantity}}</div>
                                        <div class="btn btn-danger productIncDec" style="padding: 1px 7px 1px 7px;" onclick=DecreaseProduct(event,{{$CartProduct->id}})>-</div>
                                    </div>
                                </td>
                                <td>{{$CartProduct->price}}</td>
                                <td id="totalPriceUpd-{{$CartProduct->id}}">{{$CartProduct->attributes->QuantityPrice}}</td>
                                <td style="font-size:20px" class="text-danger">
                                    <a onclick=DeleteCart({{$CartProduct->id}})>
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-lg-4 col-md-6 col-12 mt-4 opacity-fontFamily text-lg-start text-center">
                <h3 class="d-inline pb-2 " id="proceedFormHead">ORDER SUMMERY</h3>
                <div class="d-flex justify-content-lg-start justify-content-center">
                    <div class="p-4 mt-4 textStyle proceedForm border border-dark" style="width:500px">
                        <ul class="d-flex list-unstyled justify-content-between mb-0 pt-2 pb-2">
                            <li ><b>Subtotal:</b></li>
                            <li id="TotalQuantityPrice">{{Cart::Session(Auth::id())->getSubTotal()}}</li>
                        </ul>
                        <ul class="d-flex list-unstyled justify-content-between pb-2  mb-0 borderBottomSet">
                            <li><b>Shipping:</b></li>
                            <li id="Shipping">$0</li>
                        </ul>
                        <ul class="d-flex list-unstyled justify-content-between  pt-2">
                            <li><b>Total:</b></li>
                            <li id="TotalPrice">{{Cart::Session(Auth::id())->getSubTotal()}}</li>
                        </ul>
                        <button class="btn btn-dark text-light rounded-5 w-100 mt-3" onclick="window.location.href='{{route('CartProceed')}}'">Next</button>
                    </div>
                </div>
            </div>
        </div>
    @else
    <div class="row mb-3 ms-lg-4 ms-sm-2 ms-1 me-lg-4 me-sm-2 me-1 CommonLighColor" id="CartEmpty">
        <div class="col-12 p-5">
            <h3 style="text-align:center;opacity:0.7;font-family:sans-serif">Empty Cart !</h3>
        </div>
    </div>
    @endif
   
    
@endsection
@section("ActionSheet")
    <script type="text/javascript">
        function IncreaseProduct(event,id,ProductQuantity){
            let PlusTag=event.target.nextElementSibling;
            let IncreaseValue=parseInt(PlusTag.textContent);
            if(IncreaseValue<ProductQuantity){
                IncreaseValue+=1;
                PlusTag.textContent=IncreaseValue;

                jQuery.ajax({
                    url: "{{ route('CartPage.update', ':id') }}".replace(':id', id),
                    type:'PUT',
                    data:{
                        "CartProductId":parseInt(id),
                        "IncDec":'Increase'
                    },
                    dataType:'json',
                    success:function(response){
                        if(response.status==true){
                            jQuery("#totalPriceUpd-"+response.productId).text(response.totalPrice);
                            jQuery("#TotalQuantityPrice").text(response.TotalQuantityPrice);
                            jQuery("#TotalPrice").text(response.TotalQuantityPrice);

                        }
                    }
                });
            }
            else{
                alert("Only " + ProductQuantity + " products available in stock");
            }
          
        }
        function DecreaseProduct(event,id){
            let MinusTag=event.target.previousElementSibling;
            let decreaseValue=parseInt(MinusTag.textContent);
            if(decreaseValue>1){
                decreaseValue-=1;
                MinusTag.textContent=decreaseValue;
                jQuery.ajax({
                    url: "{{ route('CartPage.update', ':id') }}".replace(':id', id),
                    type:'PUT',
                    data:{
                        "CartProductId":parseInt(id),
                        "IncDec":'Decrease'
                    },
                    dataType:'json',
                    success:function(response){
                        if(response.status==true){
                            jQuery("#totalPriceUpd-"+response.productId).text(response.totalPrice);
                            jQuery("#TotalQuantityPrice").text(response.TotalQuantityPrice);
                            jQuery("#TotalPrice").text(response.TotalQuantityPrice);

                        }
                    }
                });
            }
          
        }
        function DeleteCart(CartProductId){
            if(confirm('Are you want to delete this products')){
                jQuery.ajax({
                    url: "{{ route('CartPage.destroy', ':id') }}".replace(':id', CartProductId),
                    type:'DELETE',
                    data:{
                        "CartProductId":CartProductId
                    },
                    dataType:'json',
                    success:function(response){
                        if(response.status==true){
                            if(document.getElementById("cartDataTable").firstElementChild.id!="showMessage"){
                                messageShowHTML=`
                                            <div class="alert alert-warning alert-dismissible fade show mb-0 mt-2" role="alert" id="showMessage">
                                                <i class="fa-solid fa-check" style="font-weight: bold"></i> ${response.title} 
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                        `
                                    jQuery('#cartDataTable').prepend(messageShowHTML);
                            }
                        let rowTag=document.getElementById("del-"+CartProductId);
                        let bodyTag=document.getElementById("tbodyData");
                        bodyTag.removeChild(rowTag);
                        jQuery("#TotalQuantityPrice").text(response.TotalQuantityPrice);
                        jQuery("#TotalPrice").text(response.TotalQuantityPrice);
                      
                        for(let i=0;i<=(jQuery(".TotalProductsCount")).length;i++){
                            jQuery(jQuery(".TotalProductsCount")[i]).text(response.Count)
                        }
                        if(bodyTag.getElementsByTagName('tr').length < 1){
                            if(jQuery("#cartNotEmpty").hasClass('d-flex')){
                               
                                jQuery("#cartNotEmpty").removeClass('d-flex')
                                jQuery("#cartNotEmpty").addClass('d-none')
                                let emptyCart=`
                                <div class="row mb-3 ms-lg-4 ms-sm-2 ms-1 me-lg-4 me-sm-2 me-1 CommonLighColor" id="CartEmpty">
                                    <div class="col-12 p-5">
                                        <h3 style="text-align:center;opacity:0.7;font-family:sans-serif">Empty Cart !</h3>
                                    </div>
                                </div>
                            `
                                document.getElementById("cartNotEmpty").insertAdjacentHTML('afterend',emptyCart)
                                
                            }
                            {{--  jQuery("#CartEmpty").html(emptyCart)  --}}

                        }
                        jQuery("#totalProductsNumber").text(response.Count);
                        {{--  console.log(rowTag);  --}}
                            
                        }
                    }
                });
            }
        }
    </script>
@endsection