@extends("AllUsersPages.layouts.topBar")
@section("UserStyleSheet")
    <link href="{{asset('AllUsers/css/ReviewsPolicies.css')}}" rel="stylesheet">
@show
@section('timeName','Reviews')

@section('row 2')
<div class="row mb-3 ms-lg-4 ms-sm-2 ms-1 me-lg-4 me-sm-2 me-1" style="margin-top:10px; ">
    <div class="col-12 border" style="background-color: rgb(243, 243, 243);">
        <nav aria-label="breadcrumb" class="" style="transform: translateY(5px)">
            <ol class="breadcrumb bg-transparent">
                <li class="breadcrumb-item"><a href="{{asset(route('Home'))}}" class="">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Reviews</li>
            </ol>
        </nav>
    </div>
</div>
@endsection
@section('row 3')
    <div class="row ms-lg-4 ms-sm-2 ms-1 me-lg-4 me-sm-2 me-1 pb-3 CommonLighColor">
        <div class="col-12 justify-content-center text-center">
            <h1 class="text-center mt-3 headingShadow">Customer Reviews</h1>
            <ul class="list-unstyled text-warning justify-content-center text-center">
                <li>
                    <li class="text-dark text-center me-2 d-inline" style="font-size:18px;padding:0px 5px 0px 5px;font-weight:bold;box-shadow:1px 1px 2px 1px rgb(120, 120, 219)">
                        {{$average}}
                    </li>
                    <x-UserComp.ratings :ratingsPer="$average" :fontSize="22"></x-UserComp.ratings>
                    <span class="blogsCard d-block" style="color: black;opacity:0.7; font-size: 15px;font-family: sans-serif;">Based on {{$RatingCount}} reviews</span>
                </li>
            </ul>
        </div>
        <div class="col-12 mt-3">
            @isset($AllRatings)
                @foreach ($AllRatings as $Rating)
                    <div class="d-flex bg-light">
                        @php
                            $user=$Rating->user;
                            $product=$Rating->product;
                            $producImg=$product->productImages()->first();
                        @endphp
                        <div class="p-2 ms-2" style="max-height:70px; max-width:70px;">
                            @if ($user->image !=NULL)
                                <img src="{{asset($user->image)}}" class=" mt-5 profileImg rounded-circle img-fluid object-fit-cover" style="max-height:100%;max-width:100%">
                            @else
                                <img src="{{asset('images/profile.jfif')}}" class=" mt-5 profileImg rounded-circle img-fluid object-fit-cover" style="max-height:100%;max-width:100%">
                            @endif
                            <p class="text-center blogsCard" style="font-size: 13px;font-family: sans-serif;">{{$user->name}}</p>
                        </div>
                        <div class="flex-grow-1 pt-4 ps-4 pb-0 border-bottom">
                            <ul class="list-unstyled text-warning mb-0">
                                <li style=" font-family: sans-serif;">
                                    <x-UserComp.ratings :ratingsPer="$Rating->ratings" :fontSize="15"></x-UserComp.ratings>
                                    <p class="blogsCard text-dark d-block" style="font-size: 13px">{{$Rating->comments}}</p>
                                </li>
                            </ul>
                            <figure style="max-height:100px;">
                                <img src="{{asset('Admin/images/products/uploads/'.$producImg->name)}}" class="img-fluid object-fit-cover" style="max-width:70%; max-height:70px;">
                                <figcaption class="blogsCard" style="font-size: 13px;font-family: sans-serif;">{{$product->title}}</figcaption>
                            </figure>
                        </div>
                    </div>
                @endforeach
            @endisset
           
           
        </div>
    </div>
@endsection