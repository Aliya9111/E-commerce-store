@extends("AllUsersPages.layouts.topBar")
@section("UserStyleSheet")
    <link href="{{asset('AllUsers/css/profileCart.css')}}" rel="stylesheet">
@show
@section('timeName','Submit')

@section('row 2')
<div class="row mb-3 ms-lg-4 ms-sm-2 ms-1 me-lg-4 me-sm-2 me-1" style="margin-top:10px; ">
    <div class="col-12 border" style="background-color: rgb(243, 243, 243);">
        <nav aria-label="breadcrumb" class="" style="transform: translateY(5px)">
            <ol class="breadcrumb bg-transparent">
                <li class="breadcrumb-item"><a href="{{asset(route('Home'))}}" class="">Home</a></li>
                <li class="breadcrumb-item"><a href="{{asset(route('Home'))}}" class=""></a></li>
                <li class="breadcrumb-item active" aria-current="page">Sub Category</li>
            </ol>
        </nav>
    </div>
</div>
@endsection

@section('row 3')
<div class="row mb-3 ms-lg-4 ms-sm-2 ms-1 me-lg-4 me-sm-2 me-1 CommonLighColor" id="CartEmpty">
    <div class="col-12 p-5" style="text-align:center;opacity:0.9;font-family:sans-serif">
        <h3 >Order Submit  <i class="fa-solid fa-circle-check"></i></h3>
        <p>Your Order id is <b>:</b> {{$orderId}}</p>
        @php
            use Darryldecode\Cart\Facades\CartFacade as Cart;
            Cart::session(Auth::id())->clear();
        @endphp
    </div>
</div>
@endsection
@section("ActionSheet")
    <script src="{{asset('AllUsers/js/cart.js')}}"></script>
@endsection