<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style src="{{asset('bootstrap/css/all.css')}}"></style>
    <style src="{{asset('bootstrap/css/bootstrap.min.css')}}"></style>
    <link href="{{ asset('bootstrap/css/all.css') }}" rel="stylesheet">
    <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet"> 
    <link href="{{ asset('AllUsers/css/home.css') }}" rel="stylesheet"> 
    <script src="{{asset('bootstrap/js/jQuery.min.js')}}"></script>

    @section("UserStyleSheet")
    @show
    <title>@yield("timeName")</title>
    <style>
        body{
            overflow-x: hidden;
        }
        @media screen and (max-width:320px){
            body{
                overflow-x: auto;
            }
        }
    </style>
</head>
<body>
    @if (Auth::check())
        @php
            $CartContentlength=count(Darryldecode\Cart\Facades\CartFacade::Session(Auth::id())->getContent());
            $FavouriteProductsId=App\Helper\Helper::FavouriteProducts();
        @endphp
    @endif
    @php
        $pages=App\Helper\Helper::LoadPages();
        $categories=App\Helper\Helper::categories();
    @endphp

    <div class="container-fluid w-100">
        {{--  row 0  --}}

        <div class="row bg-dark">
            <div class="col-8">
                <marquee class="text-light" id="marquee1">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s</marquee>
            </div>
            <div class="col-4 text-light" style="font-size: 14px">
                <ol class="list-unstyled d-flex gap-3 mb-0 justify-content-end">
                    <li>0302-6449507</li>
                    <li class="d-md-inline d-none">
                        <a class="me-1" href="https://www.facebook.com/profile.php?id=100074095516946" target="_blank">
                            <i class="fa-brands fa-facebook fs-5" style=" color: blue;"></i>
                        </a>
                    </li>
                    <li class="d-md-inline d-none">
                        <a class="me-1" href="https://www.instagram.com/aliyaijaz1/" target="_blank">
                            <i class="fa-brands fa-instagram fs-5" style=" color: rgb(255, 2, 255);"></i>
                        </a>
                    </li>
                </ol>
               
            </div>
            {{--  <div class="col-md-2 d-md-inline d-none  text-primary align-content-center">
               
                
            </div>  --}}
        </div>
        {{--  row 1 show tabs and categories  --}}
        <div class="position-sticky top-0" style="z-index: 15">
            <div class="row heightSet " >
                <div class="col-12 bgnav">
                    <nav class="navbar navbar-expand-lg p-0" >
                        <div class="container-fluid p-0" >
                            <div class="order-lg-0 order-1">
                                <a class="navbar-brand " href="{{route('Home')}}" style="font-weight: bold; font-size:20px;font-family:sans-serif; ">
                                    <i class="fa-solid fa-shop me-1" style="color: rgb(53, 83, 231);font-size:25px;"></i>
                                   ALIYA ST<i class="fa-brands fa-opera" style="color: rgb(53, 83, 231)"></i>RE
                                </a>
                            </div>
                            <div class="order-lg-1 order-0 p-0 ">
                                <button class="navbar-toggler border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" >
                                    <i class="fa-solid fa-bars" style="color: rgb(53, 83, 231);font-size:20px;"></i>
                                </button>
                                <div class="offcanvas offcanvas-start ms-auto" data-bs-scroll="true" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
                                    
                                    <div class="offcanvas-header d-flex p-0 steps d-lg-none d-inline" style="background-color: rgb(89, 111, 219);" style="z-index: 19">
                                        {{--  set the event on menu set Menu(event) and categories set All Cate(event)  --}}
                                        <div class="w-50 text-center p-2" id="menuId"><a href="#" class="nav-link">Menu</a></div>
                                        <div class="w-50 text-center p-2" id="CategoryId"><a href="#" class="nav-link">Categories</a></div>
                                        <button type="button" class="btn-close me-2" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                    </div>
                                    <div class="offcanvas-body">
                                        <div class=" justify-content-end" id="navbarNavAltMarkup">
                                            {{--  menu  --}}
                                            <div class="navbar-nav" style="font-family:sans-serif; font-size:16px;" id="backSet">
                                                <x-UserComp.CategoriesList></x-UserComp.CategoriesList>
                                                <a class="nav-link link-light p-2 align-self-lg-center" href="{{asset(route('Home'))}}" style="">Home</a>
                                                <a class="nav-link link-light p-2 align-self-lg-center" href="{{asset(route('Reviews'))}}">Reviews</a>
                                                @if (!empty($pages))
                                                    @foreach ($pages as $page)
                                                        <a class="nav-link link-light p-2 align-self-lg-center" href="{{route('PagesContact',$page->Name)}}">{{$page->Name}}</a>
                                                    @endforeach
                                                @endif    
                                                
                                                <div class="btnB gap-1 align-content-center">
                                                   {{--  show the profile or login\signup button base on user authentication  --}}
                                                    @if (Auth::check())
                                                        <div class="profileSet btn-group align-items-center">
                                                            <a class="nav-link position-relative d-flex align-items-center p-0" id="showHideProfile">
                                                                @if (Auth::user()->image)
                                                                    <img src="{{asset(Auth::user()->image)}}" class="img-fluid" alt="" style="height: 35px;width:35px">
                                                                @else
                                                                    <img src="{{asset('images/profile.jfif')}}" class="img-fluid" alt="" style="height: 35px;width:35px">
                                                                @endif
                                                                <span class="pSize ps-1 @section('textColor') link-light @show" style="font-size: 12px;text-decoration:underline white;" onclick="window.location.href='{{route('UserProfile')}}'">{{Auth::user()->name}}</span>
                                                            </a>
                                                        </div>
                                                    @else
                                                        <div class="btn-group">
                                                            <a class="btn rounded-pill btnBack mt-0" style="width: 80px;z-index:99" href="{{asset(route('login'))}}">Login</a>
                                                            <a class="btn btnBack mt-0 btnBackSignup" style=" margin-left:-14px;" href="{{asset(route('register'))}}">Signup</a>
                                                        </div>
                                                        
                                                    @endif
                                                    <div class="d-lg-none d-flex  text-primary mt-3">
                                                        <a class="nav-link me-1" href="https://www.facebook.com/profile.php?id=100074095516946" target="_blank">
                                                            <i class="fa-brands fa-facebook fs-5" style=" color: blue;"></i>
                                                        </a>
                                                        <a class="nav-link me-1" href="https://www.instagram.com/aliyaijaz1/" target="_blank">
                                                            <i class="fa-brands fa-instagram fs-5" style=" color: rgb(255, 2, 255);"></i>
                                                        </a>
                                                    </div>
                                                    
                                                </div>
                                            
                                            </div>
                                            <div class="d-none" id="CategoryShowId">
                                                {{--  category list show when the top nav bar hide --}}
                                                @if ($categories=App\Helper\Helper::categories())
                                                    <ol class="list-unstyled list-group bg-transparent" id="offcanvasId">
                                                        @foreach ($categories as $category)
                                                            <li class="d-flex categoryHideList mb-2" style="height:30px;">
                                                                <a href="{{route('ProductsLoad',['categoriId'=>$category->id])}}" class="nav-link link-dark" style="width: 90%"><div>{{$category->cname}}<p class="opacity-50 d-inline"> ({{App\Helper\Helper::productsQuantity('categories_id',$category->id)}})</p></div></a> 
                                                                
                                                                @php
                                                                    $subCategories=$category->subcategories()->orderBy('sname','asc')->get();
                                                                @endphp
                                                                @if ($subCategories->isNotEmpty())
                                                                    <div class="ms-auto setAngle me-1" id="rotateDiv" onclick=AngleChange(event) style="transform: rotate(360deg)">
                                                                        <i class="fa-solid fa-angle-right showList" data-bs-toggle="collapse" data-bs-target="#collapseExample-{{$category->id}}" ></i>
                                                                    </div>
                                                                @endif
                                                            </li>
                                                                @if (!empty($subCategories))
                                                                    @foreach ($subCategories as $subCategory)
                                                                        <div class="collapse mt-2" id="collapseExample-{{$category->id}}">
                                                                            <div class="card card-body border-0 bg-light p-0">
                                                                                <ol class="mt-0 ms-0" style="font-size: 15px;list-style-type:circle">
                                                                                    <li class="pb-2" style="height:30px;"><a href="{{route('ProductsLoad',['categoriId'=>$category->id,'Subcategroy'=>$subCategory->id])}}" class="nav-link link-dark ps-2 pt-1">{{$subCategory->sname}}<p class="opacity-50 d-inline"> {{App\Helper\Helper::productsQuantity('Subcategories_id',$subCategory->id)}}</p></a></li>
                                                                                </ol>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                @endif
                                                            @endforeach
                                                        </ol>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @section('cartCodeHide')
                                <div class="text-end d-lg-none d-flex order-2">
                                    <ul class="list-unstyled d-inline-flex gapSet mb-0">
                                        <li class="fs-1 shopping">
                                            <button type="button" class="btn position-relative " onclick="window.location.href='{{route('CartPage.index')}}'">
                                                <i class="fa-solid fa-cart-shopping" style="color: rgb(53, 83, 231)"></i>
                                                <span class="position-absolute top-0 start-90 translate-middle badge rounded-pill bg-danger TotalProductsCount" style="height:fit-content;width:fit-content">
                                                    @if (Auth::check())
                                                        {{$CartContentlength}}
                                                        @else
                                                        0
                                                    @endif
                                                    {{--  <span class="visually-hidden">unread messages</span>  --}}
                                                </span>
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                           
                            @show
                           
                          
                        </div>
                    </nav>
                </div>
            </div>
            {{--  row after row 1 search bar cart button  --}}
            <div class="row mt-2 mb-0 ms-0 bg-light w-100">
                <div class="col-lg-9 col-12 mt-2">
                    <div class="input-group ms-auto me-lg-0 me-auto" style="max-width: 700px"> 
                        <input type="search" placeholder="What are you looking for ?" class="form-control barSize ">
                        <div class="input-group-text p-0 border-0" >
                            <button class="btn" style="background-color:rgb(119, 133, 207);border-top-right-radius: 50px;border-bottom-right-radius:50px;">Search</button>
                        </div>
                    </div>
                </div>
                @section('cartCodeShow')
                    <div class="col-3 d-lg-inline d-none" id="cartAddNumberShow">
                        <div class="text-end d-flex">
                            <ul class="list-unstyled d-inline-flex gapSet mb-0 ms-auto">
                                <li class="fs-1 shopping">
                                    <button type="button" class="btn position-relative " onclick="window.location.href='{{route('CartPage.index')}}'">
                                        <i class="fa-solid fa-cart-shopping" style="color: rgb(53, 83, 231)"></i>
                                        <span class="position-absolute top-0 start-90 translate-middle badge rounded-pill bg-danger TotalProductsCount" style="height:fit-content;width:fit-content">
                                            @if (Auth::check())
                                                {{$CartContentlength}}
                                            @else
                                            0
                                            @endif
                                            {{--  <span class="visually-hidden">unread messages</span>  --}}
                                        </span>
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                @show
                
            </div>
        </div>
        
        {{--  row 2 only for home page  --}}
        @section('row 2')
            <div class="row mt-0">
                <div class="col-12 p-3" id="carosualImages">
                    <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner rounded-5">
                            <div class="carousel-item active" style="height: 100%">
                                <img src="{{asset('AllUsers/images/fashion.jpg')}}" class="d-block img-fluid" alt="...">
                            </div>
                            <div class="carousel-item" style="height: 100%">
                                <img src="{{asset('AllUsers/images/electronics.jpg')}}" class="d-block img-fluid" alt="...">
                            </div>
                            <div class="carousel-item" style="height: 100%">
                                <img src="{{asset('AllUsers/images/kitchen.jpg')}}" class="d-block img-fluid" alt="...">
                            </div>
                            <div class="carousel-item" style="height: 100%">
                                <img src="{{asset('AllUsers/images/appliances.jpg')}}" class="d-block  img-fluid" alt="...">
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
                
            </div> 
        @show
         {{--  row 3  --}}
        {{--  show all the categories in circle  --}}
        @section('row 3')
            @php
                use App\Helper\Helper;
            @endphp
            @if ($categories=Helper::categories())
                <div class="row mt-2 mb-3 ms-lg-4 ms-sm-2 ms-1 me-lg-4 me-sm-2 me-1 p-3" id="HWCate">
                    <h3 class="headingShadow">All Categories</h3>
                    <hr style="border:2px rgb(47, 72, 197) solid " class="mt-0">
                    @foreach ($categories as $category)
                        <div class="col-lg-1 col-md-2 col-sm-3 col-4 HW mb-2">
                            <div class=" ms-auto me-auto rounded-circle overflow-hidden">
                                @if (!empty($category->cimage))
                                    <a href="{{route('ProductsLoad',['categoriId'=>$category->id])}}">
                                        <img src="{{asset($category->cimage)}}" class="h-100 w-100 img-fluid object-fit-cover">
                                    </a>
                                    @else
                                    <a href="{{route('ProductsLoad',['categoriId'=>$category->id])}}">
                                        <img src="{{asset('AllUsers\images\no image.webp')}}" class="h-100 w-100 img-fluid object-fit-cover">
                                    </a>
                                @endif
                               
                            </div>
                            <a class="nav-link mt-1 text-center">{{$category->cname}}</a>
                        </div>
                    @endforeach
                       
                </div>

                @else
                <h3 class="headingShadow">Categories Not Available</h3>
                <hr style="border:2px rgb(47, 72, 197) solid " class="mt-0">
            @endif
          
        @show
         {{--  row 4  --}}
        {{--  additional information  --}}
        @section('row 4')
            <div class="row mt-5 Boxses justify-content-evenly">
                <div class="col-sm-3 col-6">
                    <div class="Box1 ms-auto me-auto">
                        <img src="{{asset('AllUsers/images/payment.webp')}}" class="h-100 w-100 img-fluid object-fit-contain">
                    </div>
                    <p class=" text-center mt-2">Easy and Secure Payment</p>
                </div>
                
                <div class="col-sm-3 col-6">
                    <div class="Box2 ms-auto me-auto">
                        <img src="{{asset('AllUsers/images/policy.webp')}}" class="h-100 w-100 img-fluid object-fit-contain">
                    </div>
                    <p class=" text-center mt-2">5 Days Return Policy</p>
                </div>
                
                <div class="col-sm-3 col-6">
                    <div class="Box3 ms-auto me-auto">
                        <img src="{{asset('AllUsers/images/original products.webp')}}" class="h-100 w-100 img-fluid object-fit-contain">
                    </div>
                    <p class=" text-center mt-2">100% Original Products</p>
                </div>
                
                <div class="col-sm-3 col-6">
                    <div class="Box4 ms-auto me-auto">
                        <img src="{{asset('AllUsers/images/customer satisfaction.webp')}}" class="h-100 w-100 img-fluid object-fit-contain">
                    </div>
                    <p class=" text-center mt-2">Customer Satisfaction</p>
                </div>
            </div>
        @show
       
        {{--  row 5  --}}
        {{--  featured products  --}}
        @section('row 5')
        @if($FeatureProducts=Helper::FeaturedProducts())
        <a href></a>
            <div class="row mt-3 mb-3 ms-lg-4 ms-sm-2 ms-1 me-lg-4 me-sm-2 me-1 p-3 pb-4 CommonLighColor justify-content-sm-start justify-content-center">
                <h3 class="headingShadow">Featured Products</h3>
                <hr style="border:2px solid rgb(119, 133, 207) ">
                @foreach($FeatureProducts as $FeatureProduct)
                    @php
                        $produstImages=$FeatureProduct->productImages()->first();
                        $imagePrductId=null;
                        $ratingsPer=App\Helper\Helper::ReviewsPercentage($FeatureProduct->id);
                        $ratingsPer=number_format($ratingsPer,1);
                    @endphp
                    <div class="col-xl-2 col-lg-3 col-md-4 col-6 mb-4" id="fullWidth">
                        <div class="card" style="" id="category" style="max-width: 100%;max-height:100%;" >
                            <div class="position-relative" id="showHideChild">
                                @if (!empty($produstImages))
                                    <img src="{{asset('Admin/images/products/uploads/'.$produstImages->name)}}" class="w-100 img-fluid object-fit-cover" style="height: 150px;">
                                    @php
                                        $imagePrductId=$produstImages->id;
                                    @endphp
                                @else
                                    <img src="{{asset('AllUsers/images/no image.webp')}}" class="w-100 img-fluid object-fit-cover" style="height: 150px;">
                                @endif

                                @if ($FeatureProduct->quantity>0)
                                    <div class="position-absolute bg-dark p-2 cartAdd d-flex" onclick=CartAdd({{$FeatureProduct->id}},{{$imagePrductId}})>
                                        <p class="m-0" style="white-space: nowrap">Add to Cart </p>
                                        <i class="fa-solid fa-cart-shopping" id="cartSizeAdd"></i>
                                    </div>
                                @else
                                    <div class="position-absolute bg-dark p-2 cartAdd d-flex" onclick="window.alert('Product is out of stock')">
                                        <p class="m-0" style="white-space: nowrap">Out of Stock </p>
                                    </div>    
                                @endif
                                
                                @if (Auth::check())
                                    @php
                                        $FavProductCheck=App\Helper\Helper::SingleFavPro($FeatureProduct->id);
                                    @endphp
                                    @if ($FavProductCheck)
                                        <div class="position-absolute d-inline text-light" style="top:5px;left:5px" id="heart" onclick=AddRemoveFavourite(event,{{$FeatureProduct->id}})>
                                            <i class="fa-solid fa-heart  fs-5 text-warning" ></i>
                                        </div>
                                    @else
                                        <div class="position-absolute d-inline text-light" style="top:5px;left:5px" id="heart" onclick=AddRemoveFavourite(event,{{$FeatureProduct->id}})>
                                            <i class="fa-regular fa-heart fs-5 text-warning"></i>
                                        </div>
                                    @endif
                                @else
                                    <div class="position-absolute d-inline text-light" style="top:5px;left:5px" id="heart" onclick=AddRemoveFavourite(event,{{$FeatureProduct->id}})>
                                        <i class="fa-regular fa-heart fs-5 text-warning"></i>
                                    </div>   
                                @endif
                            </div>
                            
                            <div class="card-body pSize" style="font-size: 12px; cursor: pointer;" onclick="window.location.href='{{route('CartProduct',$FeatureProduct->id)}}'">
                                <p class="card-text " >{{$FeatureProduct->title}}</</p>
                                <ul class="list-unstyled d-flex gap-5 mb-0">
                                    <li><b>Rs. {{$FeatureProduct->price}}</b></li>
                                    @if ($FeatureProduct->compare_price)
                                        <li style="text-decoration:line-through;opacity:0.5;" id="starPer">Rs .{{$FeatureProduct->compare_price}}</li>
                                    @endif
                                </ul>
        
                                <ul class="list-unstyled d-flex mt-2 text-warning mb-0" id="starPer">
                                    <x-UserComp.ratings :ratingsPer="$ratingsPer" :fontSize="15"></x-UserComp.ratings>
                                    <li class="text-dark text-center ms-2" style="font-size:15px;padding:0px 5px 0px 5px;font-weight:bold;">
                                        {{$ratingsPer}}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
     
       
        @show
        {{--  row 6  --}}
        {{--  latest products  --}}
        @section('row 6')
            @if ($latestProducts=Helper::LatestProducts())
                <div class="row mt-3 mb-3 ms-lg-4 ms-sm-2 ms-1 me-lg-4 me-sm-2 me-1 p-3 pb-4 CommonLighColor justify-content-sm-start justify-content-center">
                    <h3 class="headingShadow">Latest Products</h3>
                    <hr style="border:2px solid rgb(119, 133, 207) ">
                    @foreach($latestProducts as $latestProduct)
                        @php
                            $latestProductsImages=$latestProduct->productImages()->first();
                            $imagePrductId=null;
                            $ratingsPer=App\Helper\Helper::ReviewsPercentage($latestProduct->id);
                            $ratingsPer=number_format($ratingsPer,1);
                        @endphp
                        <div class="col-xl-2 col-lg-3 col-md-4 col-6 mb-4" id="fullWidth">
                            <div class="card" style="" id="category" style="max-width: 100%;max-height:100%;">
                                <div class="position-relative" id="showHideChild">
                                    @if ($latestProductsImages)
                                        <img src="{{asset('Admin/images/products/uploads/'.$latestProductsImages->name)}}" class="w-100 img-fluid object-fit-cover" style="height: 150px;">
                                        @php
                                            $imagePrductId=$latestProductsImages->id;
                                        @endphp
                                    @else
                                        <img src="{{asset('AllUsers/images/no image.webp')}}" class="w-100 img-fluid object-fit-cover" style="height: 150px;">  
                                    @endif
                                   
                                    @if ($latestProduct->quantity>0)
                                        <div class="position-absolute bg-dark p-2 cartAdd d-flex" onclick=CartAdd({{$latestProduct->id}},{{$imagePrductId}})>
                                            <p class="m-0" style="white-space: nowrap">Add to Cart </p>
                                            <i class="fa-solid fa-cart-shopping" id="cartSizeAdd"></i>
                                        </div>
                                    @else
                                        <div class="position-absolute bg-dark p-2 cartAdd d-flex" onclick="window.alert('Product is out of stock')">
                                            <p class="m-0" style="white-space: nowrap">Out of Stock </p>
                                        </div>    
                                    @endif
                                    @if (Auth::check())
                                    @php
                                        $FavProductCheck=App\Helper\Helper::SingleFavPro($latestProduct->id);
                                    @endphp
                                    @if ($FavProductCheck)
                                        <div class="position-absolute d-inline text-light" style="top:5px;left:5px" onclick=AddRemoveFavourite(event,{{$latestProduct->id}})>
                                            <i class="fa-solid fa-heart  fs-5 text-warning"></i>
                                        </div>
                                    @else
                                        <div class="position-absolute d-inline text-light" style="top:5px;left:5px" onclick=AddRemoveFavourite(event,{{$latestProduct->id}})>
                                            <i class="fa-regular fa-heart fs-5 text-warning" ></i>
                                        </div>
                                    @endif
                                @else
                                    <div class="position-absolute d-inline text-light" style="top:5px;left:5px" onclick=AddRemoveFavourite(event,{{$latestProduct->id}})>
                                        <i class="fa-regular fa-heart fs-5 text-warning" ></i>
                                    </div>   
                                @endif
                                </div>
                                
                                <div class="card-body pSize" style="font-size: 12px;cursor: pointer;" onclick="window.location.href='{{route('CartProduct',$latestProduct->id)}}'">
                                    <p class="card-text " >{{$latestProduct->title}}</p>
                                    <ul class="list-unstyled d-flex gap-5 mb-0">
                                        <li><b>Rs. {{$latestProduct->price}}</b></li>
                                        @if ($latestProduct->compare_price)
                                            <li style="text-decoration:line-through;opacity:0.5;" id="starPer">Rs .{{$latestProduct->compare_price}}</li>
                                        @endif
                                    </ul>
            
                                    <ul class="list-unstyled d-flex mt-2 text-warning" id="starPer">
                                        <x-UserComp.ratings :ratingsPer="$ratingsPer" :fontSize="15"></x-UserComp.ratings>
                                        <li class="text-dark text-center ms-2" style="font-size:15px;padding:0px 5px 0px 5px;font-weight:bold;">
                                            {{$ratingsPer}}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
     
      
        @show
       
        {{--  row 7  --}}
        {{--  show all products with categories name  --}}
        @section('row 7')
            @if ($categories=Helper::categories())
                @foreach($categories as $category)
                    @php
                        $AllProducts=$category->products()->latest()->get();
                        $TotalProducts=$AllProducts->count();
                        $i=0;
                    @endphp
                    @if ($AllProducts->isNotEmpty())
                        {{--  show the products  --}}
                        <div class="row mt-3 mb-3 ms-lg-4 ms-sm-2 ms-1 me-lg-4 me-sm-2 me-1 p-3 pb-4 CommonLighColor justifu-content-sm-start justifu-content-center" id="productList-{{$category->id}}">
                            <h3 class="headingShadow">{{$category->cname}}</h3>
                            <hr style="border:2px solid rgb(119, 133, 207) ">
                            @while($i < 12)
                                @if ($i > $TotalProducts-1)
                                    @php
                                        break;
                                    @endphp
                                @endif
                                @php
                                    $product=$AllProducts[$i];
                                    $ProductsImages=$product->productImages()->first();
                                    $imagePrductId=null;
                                    $i++;
                                    $ratingsPer=App\Helper\Helper::ReviewsPercentage($product->id);
                                    $ratingsPer=number_format($ratingsPer,1);
                                @endphp
                                <div class="col-xl-2 col-lg-3 col-md-4 col-6 mb-4" id="fullWidth"  data-id={{$i-1}}>
                                    <div class="card" style="" id="category" style="max-width: 100%;max-height:100%;">
                                        <div class="position-relative" id="showHideChild">
                                            @if ($ProductsImages)
                                                <img src="{{asset('Admin/images/products/uploads/'.$ProductsImages->name)}}" class="w-100 img-fluid object-fit-cover" style="height: 150px;">
                                                @php
                                                    $imagePrductId=$ProductsImages->id;
                                                @endphp
                                            @else
                                                <img src="{{asset('AllUsers/images/no image.webp')}}" class="w-100 img-fluid object-fit-cover" style="height: 150px;">  
                                            @endif
                                           
                                            @if ($product->quantity>0)
                                                <div class="position-absolute bg-dark p-2 cartAdd d-flex" onclick=CartAdd({{$product->id}},{{$imagePrductId}})>
                                                    <p class="m-0" style="white-space: nowrap">Add to Cart </p>
                                                    <i class="fa-solid fa-cart-shopping" id="cartSizeAdd"></i>
                                                </div>
                                            @else
                                                <div class="position-absolute bg-dark p-2 cartAdd d-flex" onclick="window.alert('Product is out of stock')">
                                                    <p class="m-0" style="white-space: nowrap">Out of Stock </p>
                                                </div>    
                                            @endif
                                            @if (Auth::check())
                                            @php
                                                $FavProductCheck=App\Helper\Helper::SingleFavPro($product->id);
                                            @endphp
                                            @if ($FavProductCheck)
                                                <div class="position-absolute d-inline text-light" style="top:5px;left:5px" onclick=AddRemoveFavourite(event,{{$product->id}})>
                                                    <i class="fa-solid fa-heart  fs-5 text-warning"></i>
                                                </div>
                                            @else
                                                <div class="position-absolute d-inline text-light" style="top:5px;left:5px" onclick=AddRemoveFavourite(event,{{$product->id}})>
                                                    <i class="fa-regular fa-heart fs-5 text-warning" ></i>
                                                </div>
                                            @endif
                                        @else
                                            <div class="position-absolute d-inline text-light" style="top:5px;left:5px" onclick=AddRemoveFavourite(event,{{$product->id}})>
                                                <i class="fa-regular fa-heart fs-5 text-warning" ></i>
                                            </div>   
                                        @endif
                                        </div>
                                        
                                        <div class="card-body pSize" style="font-size: 12px;cursor: pointer;" onclick="window.location.href='{{route('CartProduct',$product->id)}}'">
                                            <p class="card-text " >{{$product->title}}</p>
                                            <ul class="list-unstyled d-flex gap-5 mb-0">
                                                <li><b>Rs. {{$product->price}}</b></li>
                                                @if ($product->compare_price)
                                                    <li style="text-decoration:line-through;opacity:0.5;" id="starPer">Rs .{{$product->compare_price}}</li>
                                                @endif
                                            </ul>
                    
                                            <ul class="list-unstyled d-flex mt-2 text-warning" id="starPer">
                                                <x-UserComp.ratings :ratingsPer="$ratingsPer" :fontSize="15"></x-UserComp.ratings>
                                                <li class="text-dark text-center ms-2" style="font-size:15px;padding:0px 5px 0px 5px;font-weight:bold;">
                                                    {{$ratingsPer}}
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endwhile
                            
                            
                        </div> 
                        <div class="row mt-3 d-none text-center" id="spinnerSet-{{$category->id}}">
                            <div class="col-12 spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                        @if ($TotalProducts > 12)
                            <div class="position-relative border d-block border-1 border-opacity-50 mt-4 " id="showMoreParent-{{$category->id}}" style="width:100%;" onclick="showMore({{$category->id}})">
                                <div class="border border-2 mt-1 position-absolute h-10 w-10 rounded-circle showMore">
                                    <i class="fa-solid fa-angle-right fs-3 m-1 d-block" style="color: rgb(131, 121, 121); height:20px ;width:20px"></i>
                                </div >
                            </div>
                            @endif 
                    @endif
                
        
                @endforeach 
            @endif
         
        @show
        
       
       
        {{--  row 8  --}}
        {{--  footer  --}}
        <div class="row mt-5" id="footerSet">
            <div class="col-md-4 col-12 text-md-left text-center">
                <h3 class="mt-3 text-primary FontFooterChangeH">Online Shoping Store</h3>
                <ul class="list-unstyled d-flex gap-3">
                    <li class="fs-3 mt-2 ms-auto">
                        <a class="nav-link" href="https://www.facebook.com/profile.php?id=100074095516946" target="_blank">
                            <i class="fa-brands fa-facebook" style=" color: blue;"></i>
                        </a>
                    </li>
                    <li class="fs-3 mt-2">
                        <a class="nav-link" href="https://www.facebook.com/profile.php?id=100074095516946" target="_blank">
                            <i class="fa-brands fa-whatsapp" style=" color: rgb(140, 218, 24);"></i>
                        </a>
                    </li>
                    <li class="fs-3 mt-2 me-auto">
                        <a class="nav-link" href="https://www.instagram.com/aliyaijaz1/" target="_blank">
                            <i class="fa-brands fa-instagram" style=" color: rgb(255, 2, 255);"></i>
                        </a>
                    </li>
                </ul>
                <a class="mt-0 FontFooterChangeC" href="#">aliyaijaxbscs@gmail.com</a>
                <p class="FontFooterChangeC">0302-0000000</p>
            </div>
            <div class="col-md-4 col-5 mt-3" >
                <h5 class="FontFooterChangeH">QUICK LINKS</h5>
                <ul class="list-unstyled FontFooterChangC">
                    <li><a class="text-dark" href="{{route('Home')}}">Home</a></li>
                    <li><a class="text-dark" href="{{route('blogs')}}">Blogs</a></li>
                    <li><a class="text-dark" href="{{route('Reviews')}}">Reviews</a></li>
                    @if (!empty($pages))
                        @foreach ($pages as $page)
                            <li><a class="text-dark" href="{{route('PagesContact',$page->Name)}}">{{$page->Name}}</a></li>
                        @endforeach
                    @endif
                </ul>
            </div>
            <div class="col-md-4 col-5 mt-3">
                <h5 class="FontFooterChangeH">PRODUCT CATEGORIES</h5>
                @if (!empty($categories))
                    <ul class="list-unstyled FontFooterChangeC">
                        @foreach ($categories as $category)
                            <li>
                                <a class="text-dark" href="{{route('ProductsLoad',['categoriId'=>$category->id])}}" class="nav-link link-dark ">
                                    {{$category->cname}}
                                </a>
                            </li>
                        @endforeach
                    </ul>    
                @endif
            </div>
        </div>
    </div>
    
    {{--  <!-- Modal -->  --}}
    <div class="modal fade" id="ModalMessage" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="window.location.reload()">Close</button>
          </div>
        </div>
      </div>
    </div>
    <script src="{{asset('bootstrap/js/all.js')}}"></script>
    <script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('gsap/gsap.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js"></script>
    <script src="{{asset('gsap/SplitText.min.js')}}"></script>
 
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        // show the list of categories
        document.getElementsByClassName('showList')[0].addEventListener('click',()=>{
            console.log('show list')
            let list=document.getElementsByClassName('listHideShow')[0];
            if(list.style.animationName=="showL"){
            console.log("enter1")

            list.style.animationName = "removeL"; // Clear animation to avoid conflict
        
            }
            else{
            console.log("enter2")

                list.style.animationName="showL"
            }
        });
        function AngleChange(e){
            let pathTag=document.getElementById("rotateDiv");
            if(pathTag.style.transform=="rotate(360deg)"){
                pathTag.style.transform="rotate(90deg)";
            }
            else{
                pathTag.style.transform="rotate(360deg)";
            }
        }
        
        jQuery.noConflict();
        jQuery(document).ready(function($){
            let menuTag= document.getElementById("backSet");
            let CategoryTag=  document.getElementById("CategoryShowId");
            console.log(menuTag)
            console.log(CategoryTag)
            $("#menuId").on('click',function(){
                console.log(menuTag)
                if(menuTag.classList.contains("d-none")){
                    console.log("menu")
                    menuTag.classList.remove("d-none")
                    menuTag.classList.add("d-inline")
                    document.getElementById("menuId").style.backgroundColor="rgba(228, 228, 15, 0.74)";
                    CategoryTag.classList.add("d-none")
                    CategoryTag.classList.remove("d-inline")
                    document.getElementById("CategoryId").style.backgroundColor="rgb(119, 133, 207)";
                }
            });
            $("#CategoryId").on('click',function(){
                if(CategoryTag.classList.contains("d-none")){
                    console.log("category")
                    CategoryTag.classList.remove("d-none")
                    CategoryTag.classList.add("d-inline")
                    document.getElementById("CategoryId").style.backgroundColor="rgba(228, 228, 15, 0.74)";
                    menuTag.classList.add("d-none")
                    menuTag.classList.remove("d-inline")
                    document.getElementById("menuId").style.backgroundColor="rgb(119, 133, 207)";
                }
            });
        })
        
        let dropIcon=document.getElementById("showHideProfile");
        dropIcon.addEventListener('click',function(){
            document.getElementById("showHidePL").classList.toggle('d-none');
            console.log("hk")
        })

        {{--  add product in cart  --}}
        function CartAdd(ProductId,imgId) {
            console.log("Product ID:", ProductId); // Debug ProductId
            console.log(imgId)
            jQuery.ajax({
                url: "{{ route('CartPage.store') }}",
                type: 'POST',
                data: {
                    "ProductId": ProductId,
                    "imageId":imgId
            },
                dataType: 'json',
                success: function(response) {
                    if(response.status==false){
                        alert(response.titleFail+' '+response.message); // Debug response
                    }
                    else{
                        for(let i=0;i<=(jQuery(".TotalProductsCount")).length;i++){
                            jQuery(jQuery(".TotalProductsCount")[i]).text(response.TotalProducts)
                        }
                        alert(response.titleSuccess+' '+response.message);
                    }
                },
                error: function(xhr, status, error) {
                    {{--  console.error("Error Details:", xhr.responseText); // Debug error details  --}}
                    console.error("Status:", status);
                    console.error("Error:", error);
                }
            });
        }
        let FavouriteProductsIdJs = [];
        function FavouriteProductsIdArray() {
            @if(Auth::check())
                @if(!empty($FavouriteProductsId))
                    FavouriteProductsIdJs = @json($FavouriteProductsId);
                @endif
            @endif    
        }
        FavouriteProductsIdArray();
      
        function addProduct(AddId){
            console.log(AddId)
            jQuery.ajax({
                url: "{{ route('AddFavourite', ':id') }}".replace(':id', AddId),
                type: 'POST', // Use POST for sending data
                data: {
                    _token: "{{ csrf_token() }}" // Add CSRF token for Laravel
                },
                dataType: 'json', // Expected response format
                success: function(response) {
                    if(response.status=='login'){
                        console.log("login")
                        window.location.href="{{route('login')}}";
                    }
                    if (response.status === true) {
                        jQuery("#ModalMessage .modal-body").html(response.message)
                        const modalElement = document.getElementById('ModalMessage');
                        const modalInstance = new bootstrap.Modal(modalElement);
                        modalInstance.show();
                    }
                    else{
                        jQuery("#ModalMessage .modal-body").html(response.message)
                        const modalElement = document.getElementById('ModalMessage');
                        const modalInstance = new bootstrap.Modal(modalElement);
                        modalInstance.show();
                    }
                    console.log(response); // Handle the response
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error); // Handle errors
                }
            });
        }
        function removeProduct(removeId){
            console.log(removeId)
            jQuery.ajax({
                url: "{{ route('RemoveFavourite', ':id') }}".replace(':id', removeId),
                type: 'DELETE', // Use DELETE for sending data
                data: {
                    _token: "{{ csrf_token() }}" // Add CSRF token for Laravel
                },
                dataType: 'json', // Expected response format
                success: function(response) {
                    if(response.status=='login'){
                        console.log("login")
                        window.location.href="{{route('login')}}";
                    }
                    if (response.status === true) {
                        jQuery("#heart").html("")
                        jQuery("#heart").html("<i class='fa-solid fa-regular  fs-5 text-warning' ></i>")
                        jQuery("#ModalMessage .modal-body").html(response.message)
                        const modalElement = document.getElementById('ModalMessage');
                        const modalInstance = new bootstrap.Modal(modalElement);
                        modalInstance.show();
                    }
                    else{
                        jQuery("#ModalMessage .modal-body").html(response.message)
                        const modalElement = document.getElementById('ModalMessage');
                        const modalInstance = new bootstrap.Modal(modalElement);
                        modalInstance.show();
                    }
                    console.log(response); // Handle the response
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error); // Handle errors
                }
            });
        }
        function AddRemoveFavourite(event,id){
            if(FavouriteProductsIdJs.includes(id)){
                FavouriteProductsIdJs.splice(FavouriteProductsIdJs.indexOf(id),1);
                removeProduct(id)
            }
            else{
                FavouriteProductsIdJs.push(id)
                addProduct(id)
            }
        }
        function showMore(categoryId){
            console.log("en")
            var lastNodeDataValue=parseInt(document.getElementById("productList-"+categoryId).lastElementChild.getAttribute("data-id"))+1;
            var parentNodeTag=document.getElementById("productList-"+categoryId);
            var SpinerTag=document.getElementById("spinnerSet-"+categoryId);
            var ShowMoreTag=document.getElementById("showMoreParent-"+categoryId);
            {{--  spinner Tag  --}}
            SpinerTag.classList.remove('d-none');
            SpinerTag.classList.add('d-block');
            {{--  show more tag  --}}
            ShowMoreTag.classList.remove('d-block');
            ShowMoreTag.classList.add('d-none');
            console.log("show");
            
            {{--  var lastNode=parentNode.lastElementChild.previousElementSibling;  --}}
            jQuery.ajax({
                url:"{{route('MoreProducts',':id')}}".replace(':id',categoryId),
                type:'GET',
                data:{
                    'productNo':lastNodeDataValue
                },
                dataType: 'json', // Expected response format
                success: function(response){
                    var products=response.products;
                    var FavProducts=response.favProducts;
                    var ratings=response.ProRatings;
                    console.log(FavProducts)
                    for(var t=0; t < products.length; t++){
                        var product=products[t];
                        var productId=product.id;
                        var rating=ratings[t].toFixed(1);
                        console.log(rating)
                        {{--  for image  --}}
                        if(product['product_images'].length > 0){
                            let imagePath='Admin/images/products/uploads/'+product['product_images'][0]['name'];
                            var imageId=product['product_images'][0]['id'];
                            var image=`<img src="{{asset('')}}${imagePath}" class="w-100 img-fluid object-fit-cover" style="height: 150px;">`
                        }
                        else{
                            var image=`<img src="{{asset('AllUsers/images/no image.webp')}}" class="w-100 img-fluid object-fit-cover" style="height: 150px;">`  
                            var imageId='';
                        }
                        {{--  for favourit product  --}}
                        var isAuthenticated=@json(Auth::check());
                        if(isAuthenticated){
                            if(FavProducts!=null && FavProducts.includes(product.id)){
                                var FavProduct=`<div class="position-absolute d-inline text-light" style="top:5px;left:5px" onclick=AddRemoveFavourite(event,${product.id})>
                                    <i class="fa-solid fa-heart fs-5 text-warning" ></i>
                                </div> `
                            }
                            else{
                                var FavProduct=`<div class="position-absolute d-inline text-light" style="top:5px;left:5px" onclick=AddRemoveFavourite(event,${product.id})>
                                    <i class="fa-regular fa-heart fs-5 text-warning" ></i>
                                </div> `
                            }
                        }
                        else{
                            var FavProduct=`<div class="position-absolute d-inline text-light" style="top:5px;left:5px" onclick=AddRemoveFavourite(event,${product.id})>
                                                <i class="fa-regular fa-heart fs-5 text-warning" ></i>
                                            </div> `
                            }
                            {{--  for rating  --}}
                            var ratingHTML=''
                            for(var i = 1; i <= 5; i++){
                                if(i <= parseInt(rating) || i - 0.1 == rating ||i - 0.9 == rating){
                                    ratingHTML+=`<small class="fa-solid fa-star text-warning me-1"></small>`
                                }
                                {{-- Full Star or 0.1,0.9 --}}
                                else if(i - 0.2 == rating || i - 0.3 == rating || i - 0.4 == rating || i - 0.5 == rating || i - 0.6 == rating || i - 0.7 == rating){
                                    ratingHTML+=`<small class="fa-regular fa-star-half-stroke text-warning me-1"></small>`
                                }
                                {{-- Empty Star --}}
                                else {
                                    ratingHTML+=`<small class="fa-regular fa-star text-warning me-1"></small>`
                                }   
                            }
                                
                        var productsQuan= product.quantity >0 ? `<div class="position-absolute bg-dark p-2 cartAdd d-flex" onclick=CartAdd(${product.id},${imageId})>
                                                                <p class="m-0" style="white-space: nowrap">Add to Cart </p>
                                                                <i class="fa-solid fa-cart-shopping" id="cartSizeAdd"></i>
                                                            </div>`
                                                            :` <div class="position-absolute bg-dark p-2 cartAdd d-flex" onclick="window.alert('Product is out of stock')">
                                                                <p class="m-0" style="white-space: nowrap">Out of Stock </p>
                                                            </div> ` 
                        var comparePrice=product.compare_price !=null ?` <li style="text-decoration:line-through;opacity:0.5;" id="starPer">Rs .${product.compare_price}</li>` : ''                                            
                        var MoreProdustsHTML=`<div class="col-xl-2 col-lg-3 col-md-4 col-6 mb-4" id="fullWidth"  data-id=${lastNodeDataValue}>
                                                <div class="card" style="" id="category" style="max-width: 100%;max-height:100%;">
                                                    <div class="position-relative" id="showHideChild">
                                                        ${image}
                                                        ${productsQuan}
                                                       ${FavProduct}
                                                        </div>
                                                    <div class="card-body pSize" style="font-size: 12px;cursor: pointer;" onclick="window.location.href='{{route('CartProduct',':id')}}'.replace(':id',${productId})">
                                                        <p class="card-text " >${product.title}</p>
                                                        <ul class="list-unstyled d-flex gap-5 mb-0">
                                                            <li><b>Rs. ${product.price}</b></li>
                                                            ${comparePrice}
                                                        </ul>
                                                        <ul class="list-unstyled d-flex mt-2 text-warning" id="starPer">
                                                            <li style="font-size: 15px; text-align-last:center;">
                                                               ${ratingHTML}
                                                            </li>
                                                            <li class="text-dark text-center ms-1" style="font-size:15px;padding:0px 5px 0px 5px;font-weight:bold;">
                                                                ${rating}
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            `
                    parentNodeTag.insertAdjacentHTML('beforeend',MoreProdustsHTML);
                    lastNodeDataValue+=1;                
                }
                {{--  spinner Tag  --}}
                SpinerTag.classList.remove('d-block');
                SpinerTag.classList.add('d-none');
                {{--  show more tag  --}}
                if(lastNodeDataValue < response.ProductsCount){
                    ShowMoreTag.classList.remove('d-none');
                    ShowMoreTag.classList.add('d-block');
                }
              
            }
            });
          
        }
</script>

@section("ActionSheet")

@show
   
</body>
</html>