@extends("AllUsersPages.layouts.topBar")
@section("UserStyleSheet")
    <link href="{{asset('AllUsers/css/profileCart.css')}}" rel="stylesheet">
@show
@section('timeName','Proceed')
@section('row 2')
<div class="row mb-3 ms-lg-4 ms-sm-2 ms-1 me-lg-4 me-sm-2 me-1" style="margin-top:10px; ">
    <div class="col-12 border" style="background-color: rgb(243, 243, 243);">
        <nav aria-label="breadcrumb" class="" style="transform: translateY(5px)">
            <ol class="breadcrumb bg-transparent">
                <li class="breadcrumb-item"><a href="{{asset(route('Home'))}}" class="">Home</a></li>
                <li class="breadcrumb-item"><a class="">Cart</a></li>
                <li class="breadcrumb-item active" aria-current="page">Proceed</li>
            </ol>
        </nav>
    </div>
</div>
@endsection


@section('row 3')
        <div class="row mb-3 ms-lg-4 ms-sm-2 ms-1 me-lg-4 me-sm-2 me-1 pb-4 d-flex CommonLighColor justify-content-lg-evenly justify-content-center" id="cartNotEmpty">
            <div class="col-lg-7 col-md-6 col-12 p-4 mt-4 proceedForm">
                <h3 class="d-inline pb-2" id="proceedFormHead">SHIPPING ADDRESS</h3>
                <form class="mt-4" id="form1">
                    @csrf
                    <input type="text" class="form-control mt-2" name="fname" id="fname" placeholder="Fist Name" style="font-size: 13px">
                    <p class="pError" id="fnameP"></p>
                    <input type="text" class="form-control mt-2" id="lname" name="lname" placeholder="Last Name" style="font-size: 13px">
                    <p class="pError" id="lnameP"></p>
                    <input type="email" class="form-control mt-2" id="email" name="email" placeholder="Email" style="font-size: 13px">
                    <p class="pError" id="emailP"></p>
                    <select class="form-select mt-2" name="CountryId" id="CountryId" onchange=CountryShipping(event) style="font-size: 12px;opacity:0.9; font-family:sans-serif;">
                        <option value="none">Select a Country</option>
                        @if (!empty($countries))
                            @foreach ($countries as $country)
                                <option value="{{$country->id}}">{{$country->name}}</option>
                            @endforeach
                        @endif
                    </select>
                    <input type="hidden" value="0" name="oldCountry" id="oldCountryId">
                    <p class="pError" id="CountryIdP"></p>
                    
                    <textarea name="address" class="mt-2 form-control" id="address" cols="15" placeholder="Address" style="font-size: 13px"></textarea>
                    <p class="pError" id="addressP"></p>
                    
                    <input type="text" class="form-control mt-2" name="apartment" placeholder="Apartment, suite, unit, etc (optional)" style="font-size: 13px">
                    <div class="row mt-2 justify-content-between">
                        <div class="col-4">
                            <input type="text" class="form-control" name="city" id="city" placeholder="City" style="font-size: 13px">
                            <p class="pError" id="cityP"></p>
                        </div>
                        <div class="col-4">
                            <input type="text" class="form-control" name="state" id="state" placeholder="State" style="font-size: 13px">
                            <p class="pError" id="stateP"></p>
                        </div>
                        <div class="col-4">
                            <input type="text" class="form-control" name="zipCode" id="zipCode" placeholder="Zip" style="font-size: 13px">
                            <p class="pError" id="zipCodeP"></p>
                        </div>
                    </div>
                    <textarea name="note" class="mt-2 form-control" id="" cols="10" placeholder="Order Notes. (Optional)" style="font-size: 13px"></textarea>
                    <input type="hidden" name="totalPrice" value="{{Cart::Session(Auth::id())->getSubTotal()}}" id="TotalPriceInput">

                    {{--  apply coupan  --}}
                    <div class="btn-group mt-2">
                        <input type="text" class="form-control" name="coupon_code" id="coupanCodeId" placeholder="Enter coupan code">
                        <button class="btn btn-dark text-light" style="background-color: #2d2f31" id="coupanCodebtnId" onclick=CoupanCheck()>Apply</button>
                        <input type="hidden" value="0" name="oldCoupanPrice" id="oldCoupanPrice">
                        <input type="hidden" value="0" name="coupanCheck" id="coupanCheckId">
                    </div>
                    <p class="pError" id="coupanCodeP"></p>
                </form>
            </div>
            <div class="col-lg-4 col-md-6 col-12 mt-4 opacity-fontFamily text-lg-start text-center" >
                <h3 class="d-inline pb-2 " id="proceedFormHead">ORDER SUMMERY</h3>
                <div class="d-flex justify-content-lg-start justify-content-center">
                    <div class="p-4 mt-4 textStyle proceedForm" style="width:500px">
                        @php
                            $CartProducts=Darryldecode\Cart\Facades\CartFacade::Session(Auth::id())->getContent();
                        @endphp
                        @foreach ($CartProducts as $CartProduct)
                            <div class="d-flex w-100 borderBottomSet pb-1" style="font-size: 13px">
                                <div style="width:70%">{{$CartProduct->name}} x {{$CartProduct->quantity}}</div>
                                <div style="width:20%" class="text-end ms-auto">${{$CartProduct->attributes->QuantityPrice}}</div>
                            </div>
                        @endforeach
                    
                        <ul class="d-flex list-unstyled justify-content-between mb-0 pt-2 pb-2">
                            <li><b>Subtotal:</b></li>
                            <li id="TotalQuantityPrice">${{Cart::Session(Auth::id())->getSubTotal()}}</li>
                        </ul>
                        <ul class="d-flex list-unstyled justify-content-between pb-2  mb-0">
                            <li><b>Shipping:</b></li>
                            <li id="Shipping">$0</li>
                        </ul>
                        {{--  show discount amount  --}}
                        <ul class="d-flex list-unstyled justify-content-between d-none pb-2  mb-0 borderBottomSet" id="discountParent">
                            <li><b>Discount: <i class="fa-solid fa-trash text-danger" onclick="removecoupan()"></i></b></li>
                            <li id="discount"></li>
                        </ul>
                        <ul class="d-flex list-unstyled justify-content-between  pt-2">
                            <li><b>Total:</b></li>
                            <li id="TotalPrice">${{Cart::Session(Auth::id())->getSubTotal()}}</li>
                        </ul>
                    </div>
                </div>
                <div class="d-flex justify-content-lg-start justify-content-center">
                    <div class="p-4 mt-4 textStyle proceedForm"  style="width:500px">
                        <h6 class="p-2" style=""><b>Payment Method</b></h6>
                        <div class="form-check">
                            <input type="radio" checked name="Paymenttype" onclick="PaymentMethod(event)" id="COD" class="form-check-input">
                            <label class="form-check-label" >COD</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" name="Paymenttype" onclick="PaymentMethod(event)" id="strive" class="form-check-input">
                            <label class="form-check-label" >Strip</label>
                        </div>
                        <div class="d-none" id="CardPay">
                            <form id="form2">
                                @csrf
                                <label for="" class="mt-2"><b>Card Number</b></label><br>
                                <input type="text" class="form-control" id="CardNumber" name="CardNumber" placeholder="Valid Cart Number" style="font-size: 13px">
                                <p class="pError" id="CardNumberP"></p>
                                <div class="row justify-content-between mt-2">
                                    <div class="col-6">
                                        <label for="" class="mt-2"><b>Expiry Date</b></label><br>
                                        <input type="date" class="form-control" id="expirayDate" name="expirayDate" placeholder="Expiry Date" style="font-size: 13px">
                                        <p class="pError" id="expirayDateP"></p>
                                    </div>
                                    <div class="col-6">
                                        <label for="" class="mt-2"><b>CVV Code</b></label><br>
                                        <input type="text" class="form-control" id="cvv" name="cvv" placeholder="123" style="font-size: 13px">
                                        <p class="pError" id="cvvP"></p>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <button class="btn btn-dark text-light rounded-5 w-100 mt-3" id="payNowId" onclick=SubmitOrder(event)>Pay Now</button>
                    </div>
                </div>
            </div>
        </div>
   
    
@endsection
@section("ActionSheet")
    <script type="text/javascript">
        let paymentType="COD";
        function PaymentMethod(event){
                let targetTag=event.target;
                let StriveTag=document.getElementById("CardPay");

                if(targetTag.id=='COD'){
                    paymentType=event.target.id;
                    if(StriveTag.classList.contains("d-block")){
                        StriveTag.classList.remove("d-block")
                        StriveTag.classList.add("d-none")

                    }
                }
                else{
                    paymentType=event.target.id;
                    if(StriveTag.classList.contains("d-none")){
                        StriveTag.classList.remove("d-none")
                        StriveTag.classList.add("d-block")
                    }
                }
        }
        function CountryShipping(event){
            let CountryId=event.target.value;
            console.log(CountryId);
            let subtotal=jQuery("#TotalPriceInput").val();
            console.log(subtotal);
            jQuery.ajax({
                url: "{{ route('CountryShip') }}",
                type:'GET',
                data:{
                    "CountryId":CountryId,
                    "subtotal":subtotal,
                    'oldCountry':jQuery("#oldCountryId").val()
                },
                dataType:'json',
                success:function(response){
                    if(response.status==true){
                        jQuery("#Shipping").text("$"+response.Shipprice);
                        jQuery("#TotalPrice").text(response.totalPrice);
                        jQuery("#TotalPriceInput").val(response.totalPrice);
                        jQuery("#oldCountryId").val(response.NewCountryShipping);
                    }
                    else{
                        jQuery("#Shipping").text("$0");
                        jQuery("#TotalPrice").text(response.totalPrice);
                        jQuery("#TotalPriceInput").val(response.totalPrice);
                        jQuery("#oldCountryId").val(response.NewCountryShipping);

                    }
                }
            });
       }
        function SubmitOrder(event){
                let form1Data = jQuery("#form1").serializeArray();
                let form2Data = jQuery("#form2").serializeArray();
                let completeData=form1Data;
                jQuery("#payNowId").prop('disabled',true);
                console.log(completeData)
                if(paymentType!='COD'){
                    completeData = form1Data.concat(form2Data);
                    console.log(completeData)
                }
                jQuery.ajax({
                    url: "{{ route('SubmitOrder') }}",
                    type:'POST',
                    data:{
                        completeData,
                        'paymentType':paymentType
                    },
                    dataType:'json',
                    success: function (response) {
                        jQuery("#payNowId").prop('disabled',false);

                        let errors = response.errors;
                        console.log(errors.fname);
                
                        // Handle fname errors
                        if (errors.fname) {
                            jQuery("#fname").addClass("is-invalid");
                            jQuery("#fname").siblings("#fnameP").html(errors.fname[0]); 
                        } else {
                            jQuery("#fname").removeClass("is-invalid");
                            jQuery("#fname").siblings("#fnameP").html(""); 

                        }
                
                        // Handle lname errors
                        if (errors.lname) {
                            jQuery("#lname").addClass("is-invalid");
                            jQuery("#lname").siblings("#lnameP").html(errors.lname[0]); // Access the first error message
                        } else {
                            jQuery("#lname").removeClass("is-invalid");
                            jQuery("#lname").siblings("#lnameP").html("");
                        }
                
                        // Handle email errors
                        if (errors.email) {
                            jQuery("#email").addClass("is-invalid");
                            jQuery("#email").siblings("#emailP").html(errors.email[0]); // Access the first error message
                        } else {
                            jQuery("#email").removeClass("is-invalid");
                            jQuery("#email").siblings("#emailP").html("");
                        }
                
                        // Handle CountryId errors
                        if (errors.CountryId) {
                            jQuery("#CountryId").addClass("is-invalid");
                            jQuery("#CountryId").siblings("#CountryIdP").html(errors.CountryId[0]); // Access the first error message
                        } else {
                            jQuery("#CountryId").removeClass("is-invalid");
                            jQuery("#CountryId").siblings("#CountryIdP").html("");
                        }
                
                        // Handle address errors
                        if (errors.address) {
                            jQuery("#address").addClass("is-invalid");
                            jQuery("#address").siblings("#addressP").html(errors.address[0]); // Access the first error message
                        } else {
                            jQuery("#address").removeClass("is-invalid");
                            jQuery("#address").siblings("#addressP").html("");
                        }
                
                        // Handle city errors
                        if (errors.city) {
                            jQuery("#city").addClass("is-invalid");
                            jQuery("#city").siblings("#cityP").html(errors.city[0]); // Access the first error message
                        } else {
                            jQuery("#city").removeClass("is-invalid");
                            jQuery("#city").siblings("#cityP").html("");
                        }
                
                        // Handle state errors
                        if (errors.state) {
                            jQuery("#state").addClass("is-invalid");
                            jQuery("#state").siblings("#stateP").html(errors.state[0]); // Access the first error message
                        } else {
                            jQuery("#state").removeClass("is-invalid");
                            jQuery("#state").siblings("#stateP").html("");
                        }
                
                        // Handle zipCode errors
                        if (errors.zipCode) {
                            jQuery("#zipCode").addClass("is-invalid");
                            jQuery("#zipCode").siblings("#zipCodeP").html(errors.zipCode[0]); // Access the first error message
                        } else {
                            jQuery("#zipCode").removeClass("is-invalid");
                            jQuery("#zipCode").siblings("#zipCodeP").html("");
                        }

                        // Handle CardNumber errors
                        if (errors.CardNumber) {
                            jQuery("#CardNumber").addClass("is-invalid");
                            jQuery("#CardNumber").siblings("#CardNumberP").html(errors.CardNumber[0]); // Access the first error message
                        } else {
                            jQuery("#CardNumber").removeClass("is-invalid");
                            jQuery("#CardNumber").siblings("#CardNumberP").html("");
                        }
                        // Handle expirayDate errors
                        if (errors.expirayDate) {
                            jQuery("#expirayDate").addClass("is-invalid");
                            jQuery("#expirayDate").siblings("#expirayDateP").html(errors.expirayDate[0]); // Access the first error message
                        } else {
                            jQuery("#expirayDate").removeClass("is-invalid");
                            jQuery("#expirayDate").siblings("#expirayDateP").html("");
                        }
                        // Handle cvv errors
                        if (errors.cvv) {
                            jQuery("#cvv").addClass("is-invalid");
                            jQuery("#cvv").siblings("#cvvP").html(errors.cvv[0]); // Access the first error message
                        } else {
                            jQuery("#cvv").removeClass("is-invalid");
                            jQuery("#cvv").siblings("#cvvP").html("");
                        }
                        if(response.status==true){
                            console.log("sendemail")
                            const baseUrl = "{{ url('/') }}";
                            window.location.href=baseUrl+'/'+response.OrderDone+'/'+response.orderId
                        }
                        
                    }
                    
                });
        }
        function CoupanCheck() {
            event.preventDefault();
            let inputTag = document.getElementById("coupanCodeId").value;
            let minAmount=jQuery("#TotalPriceInput").val();
            console.log(minAmount)
            console.log(inputTag)
            jQuery.ajax({
                url: "{{ route('Coupan.show',':code') }}".replace(':code',inputTag),
                type:'GET',
                data:{
                    "minAmount":minAmount,
                },
                dataType:'json',
                success:function(response){
                    if(response.status==true){
                        console.log('true');
                        if(jQuery("#discountParent").has("d-none")){
                            jQuery("#discountParent").removeClass("d-none")
                            jQuery("#discountParent").addClass("d-block")
                        }

                        if(response.coupan.type=='percent'){
                            jQuery("#discount").html(response.coupan.discount_amount+'%')
                        }
                        else{
                            jQuery("#discount").html('$'+response.coupan.discount_amount)
                        }
                        jQuery("#TotalPrice").html('$'+response.totalPrice)
                        jQuery("#TotalPriceInput").val(response.totalPrice);
                        jQuery("#oldCoupanPrice").val(response.newCoupanPrice);
                        jQuery("#coupanCodeP").html('');
                        jQuery("#coupanCodebtnId").addClass('disabled')
                        jQuery("#coupanCheckId").val(1);
                    }
                    else{
                        jQuery("#TotalPrice").html('$'+response.totalPrice)
                        jQuery("#TotalPriceInput").val(response.totalPrice);
                        jQuery("#coupanCodeP").html(response.message);
                    }
                }
            });
        }
        function removecoupan(){
            let oldDiscount=jQuery("#oldCoupanPrice").val()
            let grandTotal=jQuery("#TotalPriceInput").val()
            let minusDiscount=grandTotal-oldDiscount;
            jQuery("#TotalPriceInput").val(minusDiscount)
            jQuery("#oldCoupanPrice").val(0)
            jQuery("#TotalPrice").text("$"+minusDiscount)
            jQuery("#discountParent").removeClass("d-block")
            jQuery("#discountParent").addClass("d-none")
            jQuery("#coupanCodeId").val('');
            jQuery("#coupanCodebtnId").removeClass('disabled')
            jQuery("#coupanCheckId").val(0);

        }
        
    </script>
@endsection