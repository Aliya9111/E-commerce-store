<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('bootstrap/css/all.css') }}" rel="stylesheet">
    <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('summernote/summernote.min.css') }}" rel="stylesheet"> {{---for text editor--}} 

    <link href="{{ asset('Admin/css/categorySub.css') }}" rel="stylesheet"> 
    <link href="{{ asset('dropzone/dist/dropzone.css') }}" rel="stylesheet"> {{--for images--}}
    <link href="{{ asset('select2/select2.min.css') }}" rel="stylesheet"> {{--for related products--}}
    <link href="{{ asset('cropper/cropper.min.css') }}" rel="stylesheet"> {{--for crop image--}}
    <link href="{{ asset('datetimepicker/jquery.datetimepicker.min.css') }}" rel="stylesheet"> {{--for crop image--}}


    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{--  <link href="{{ asset('summernote/summernote.css') }}" rel="stylesheet">   --}}

    <link href="{{ asset('Admin/css/base.css') }}" rel="stylesheet">  
    <style>
        body{
           overflow-y: hidden;
        }
        .custom-editor {
            height: 900px; 
            width: 100%;  
        }
        .profile-img{
            height: 100px;
            width: 100px;
            object-fit: cover;
        }
        .info-font{
            font-size: 15px;
            font-weight: bold;
        }
    </style>
    @section("CustomStyle")

    @show
    @section("title")

    @show 
</head>
<body style="background-color:rgb(229, 239, 248)">
    @php
        $adminData=App\Models\User::where('id',Auth::id())->first();
    @endphp
    <div class="container-fluid w-100" style="height: 100vh;">
        {{--  first row  --}}
        <div class="row bg-info">
            {{--  store name  --}}
            <div class="col-lg-2 col-sm-4 d-sm-block d-none align-content-center">
                <a class="navbar-brand " href="{{route('Home')}}" style="font-weight: bold; font-size:17px;font-family:sans-serif; ">
                    <i class="fa-solid fa-shop me-1" style="color: rgb(53, 83, 231);font-size:20px;"></i>
                   ALIYA ST<i class="fa-brands fa-opera" style="color: rgb(53, 83, 231)"></i>RE
                </a>
                <a onclick=hideColumn() style="margin-left: 12%;">
                    <i class="fa-solid fa-bars"></i>
                </a>
            </div>
            <div class="col-2 d-sm-none d-block align-items-center d-flex">
                {{-- show in mobile view and hide all the columns of this row  --}}
                <x-AdminCom.MobileNavBar></x-AdminCom.MobileNavBar>
            </div>
            <div class="col-lg-7 col-sm-5 col-7 align-content-center">
                {{--  store name  --}}
                <h2 class="text-center">
                    Product Management
                </h2>
            </div>
            {{--  user profile and logout  --}}
            <div class="col-sm-3 col-3 align-items-center justify-content-center d-flex">
                <div class="dropdown">
                   
                    <a class="nav-link " type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        @if ($adminData->image !=NULL)
                            <img src="{{asset($adminData->image)}}" class="profileImg rounded-circle img-fluid">
                        @else 
                            <img src="{{asset('images/profile.jfif')}}" class="profileImg rounded-circle img-fluid">
                        @endif
                    </a>
                   
                    <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="{{route('UpdateLoaduser',Auth::id())}}">Profile</a></li>
                      <li><a class="dropdown-item" href="{{route('logout')}}">Logout</a></li>
                    </ul>
                </div>
                <span class="ms-1 d-md-block d-none" style="font-size: 13px;font-family:sans-serif;opacity:0.9;font-weight:bold;">{{$adminData->name}}</span>
            </div>

        </div>

        {{--  second row  --}}
        <div class="row">
            
            {{--  show all tabs  --}}
            <div class="col-xl-2 col-lg-3 col-sm-4 d-sm-block d-none bg-info OpenClose border-top border-2"
                    style="overflow-y: scroll;height:100vh;padding-bottom:100px;">
                {{--Admin profile  --}}
                <div class="row">
                    <div class="col-12 justify-content-center text-center hidea d-inline mt-4">
                        <div class="card bg-info border-0">
                            <div class="ms-auto me-auto" style="max-height: 50%;max-width:50%;">
                                @if ($adminData->image !=NULL)
                                    <img src="{{asset($adminData->image)}}" class="rounded-2 img-fluid" style="height: 100%;width:100%;object-fit:cover;">
                                @else 
                                    <img src="{{asset('images/profile.jfif')}}" class="rounded-2 img-fluid" style="height: 100%;width:100%;object-fit:cover;">
                                @endif
                            </div>
                          
                            <div class="card-body info-font">
                                <p class="card-title text-light">{{$adminData->name}}</p>
                                <p class="card-text text-light mt-2" title="aliyaijazbscs@gmail.com" style="font-size: 12px;">{{$adminData->email}}</p>
                                <a href="{{route('UpdateLoaduser',Auth::id())}}" class="link-primary link-offset-1 link-opacity-1-hover">Edit <i class="fa-regular fa-pen-to-square"></i></a>
                            </div>
                        </div>
                        <hr class="border border-black border-2 mt-0">
                        
                    </div>
                </div>
                {{--  dashboard  --}}
                <div class="row mt-3 p-0">
                    <div class="col-2 align-content-center">
                        <a class="nav-link text-dark d-inline" href="{{route('dashborad')}}">
                            <i class="fa-solid fa-gauge text-dark" style="font-size: 19px"></i>
                        </a>
                    </div>
                    <div class="col-8 align-content-center hidea d-inline">
                        <a class="nav-link text-dark d-inline" href="{{route('dashborad')}}">Dashboard</a>
    
                    </div>
                </div>

                {{--  category  --}}
                <div class="row mt-2 cate" >
                    <div class="col-2 align-content-center c1 hidea d-inline">
                        <a href="{{route('Categories')}}" class="nav-link text-dark">
                            <i class="fa-solid fa-list" style="font-size: 19px"></i>
                        </a>
                    </div>

                    {{--  click on tag and open below list  --}}
                    <div class="col-10 align-content-center hidea d-inline c2">
                        <a class="nav-link text-dark d-flex justify-content-between" onclick=ChangeColorClick(event) data-bs-toggle="collapse" href="#collapseExample1" role="button" aria-expanded="false" aria-controls="collapseExample">
                            <span class="mt-1">Category</span>
                            <button  class="btn border-0 pe-0" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-angle-right"></i>
                            </button>
                        </a>
                    </div>
                    {{--  bottom list of category  --}}
                    <div class="col-12 hidea d-inline">
                        <div class="collapse border-0" id="collapseExample1">
                            <div class="card card-body bg-info border-0">
                                <ul class="list-unstyled list-group border-0">
                                    <li class="list-group-item p-0 border-bottom border-0 bg-info"><a href="{{route('Categories')}}" class="nav-link text-dark increaseTextSize" href="#">Add new</a></li>
                                    <li class="list-group-item p-0 border-bottom rounded-0 border-0 bg-info"><a class="nav-link text-dark increaseTextSize" href="{{route('AllCategries')}}">Check All</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                {{--  subcategory  --}}
                <div class="row mt-2 Subcate">
                    <div class="col-2  align-content-center sc1 hidea d-inline">
                        <a class="nav-link text-dark" href="{{route('SubCategories')}}">
                            <i class="fa-solid fa-layer-group" style="font-size: 19px"></i>
                        </a>
                    </div>
                    <div class="col-10  align-content-center hidea d-inline sc2">
                        <a class="nav-link text-dark d-flex justify-content-between" onclick=ChangeColorClick(event) data-bs-toggle="collapse" href="#collapseExample2" role="button" aria-expanded="false" aria-controls="collapseExample">
                            <span class="mt-1">SubCategory</span>
                            <button  class="btn border-0 pe-0" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-angle-right"></i>
                            </button>
                        </a>
                    </div>
                     {{--  bottom list of Subcategory  --}}
                     <div class="col-12">
                        <div class="collapse border-0" id="collapseExample2">
                            <div class="card card-body bg-info border-0">
                                <ul class="list-unstyled list-group border-0">
                                    <li class="list-group-item p-0 border-bottom border-0 bg-info"><a class="nav-link text-dark increaseTextSize" href="{{route('SubCategories')}}">Add new</a></li>
                                    <li class="list-group-item p-0 border-bottom rounded-0 border-0 bg-info"><a class="nav-link text-dark increaseTextSize" href="{{route('AllSubCategries')}}">Check All</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                {{--  brands  --}}
                <div class="row mt-2 brand">
                    <div class="col-2  align-content-center b1 hidea d-inline">
                        <a class="nav-link text-dark" href="{{route('Brand')}}">
                            <i class="fa-solid fa-copyright" style="font-size: 19px"></i>
                        </a>
                    </div>
                    <div class="col-10 align-content-center hidea d-inline b2">
                        <a class="nav-link text-dark d-flex justify-content-between" onclick=ChangeColorClick(event) data-bs-toggle="collapse" href="#collapseExample3" role="button" aria-expanded="false" aria-controls="collapseExample">
                            <span class="mt-1">Brands</span>
                            <button  class="btn border-0 pe-0" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-angle-right"></i>
                            </button>
                        </a>
                    </div>
                    {{--  bottom list of brands  --}}
                     <div class="col-12">
                        <div class="collapse border-0" id="collapseExample3">
                            <div class="card card-body bg-info border-0">
                                <ul class="list-unstyled list-group border-0">
                                    <li class="list-group-item p-0 border-bottom border-0 bg-info"><a class="nav-link text-dark increaseTextSize" href="{{route('Brand')}}">Add new</a></li>
                                    <li class="list-group-item p-0 border-bottom rounded-0 border-0 bg-info"><a class="nav-link text-dark increaseTextSize" href="{{route('AllBrands')}}">Check All</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                {{--  products  --}}
                <div class="row mt-2 pro">
                    <div class="col-2  align-content-center p1 hidea d-inline">
                        <a class="nav-link text-dark" href="{{route('product')}}">
                            <i class="fa-brands fa-product-hunt" style="font-size: 19px"></i>
                        </a>
                    </div>
                    <div class="col-10 align-content-center hidea d-inline p2">
                        <a class="nav-link text-dark d-flex justify-content-between" onclick=ChangeColorClick(event) data-bs-toggle="collapse" href="#collapseExample4" role="button" aria-expanded="false" aria-controls="collapseExample">
                            <span class="mt-1">Products</span>
                            <button  class="btn border-0 pe-0" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-angle-right"></i>
                            </button>
                        </a>
                    </div>
                     {{--  bottom list of products  --}}
                     <div class="col-12">
                        <div class="collapse border-0" id="collapseExample4">
                            <div class="card card-body bg-info border-0">
                                <ul class="list-unstyled list-group border-0">
                                    <li class="list-group-item p-0 border-bottom border-0 bg-info"><a class="nav-link text-dark increaseTextSize" href="{{route('product')}}">Add new</a></li>
                                    <li class="list-group-item p-0 border-bottom rounded-0 border-0 bg-info"><a class="nav-link text-dark increaseTextSize" href="{{route('productLoad')}}">Check All</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                {{--  shipping  --}}
                <div class="row mt-2 pro">
                    <div class="col-2 align-content-center p1 hidea">
                        <i class="fa-solid fa-truck-fast" style="font-size: 19px"></i>
                    </div>
                    <div class="col-10 align-content-center hidea d-inline p2">
                        <a class="nav-link text-dark d-flex justify-content-between" onclick=ChangeColorClick(event) data-bs-toggle="collapse" href="#collapseExampleShipp" role="button" aria-expanded="false" aria-controls="collapseExample">
                            <span class="mt-1">Shipping</span>
                            <button  class="btn border-0 pe-0" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-angle-right"></i>
                            </button>
                        </a>
                    </div>
                    {{--  bottom list of shipping  --}}
                     <div class="col-12">
                        <div class="collapse border-0" id="collapseExampleShipp">
                            <div class="card card-body bg-info border-0">
                                <ul class="list-unstyled list-group border-0">
                                    <li class="list-group-item p-0 border-bottom border-0 bg-info"><a class="nav-link text-dark increaseTextSize" href="{{route('Shipping.create')}}">Add new</a></li>
                                    <li class="list-group-item p-0 border-bottom rounded-0 border-0 bg-info"><a class="nav-link text-dark increaseTextSize" href="{{route('Shipping.index')}}">Check All</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                 {{--  Coupan  --}}
                 <div class="row mt-2 pro">
                    <div class="col-2  align-content-center hidea p1">
                        <i class="fa-solid fa-money-bill" style="font-size: 19px;"></i>
                    </div>
                    <div class="col-10 align-content-center hidea d-inline p2">
                        <a class="nav-link text-dark d-flex justify-content-between" onclick=ChangeColorClick(event) data-bs-toggle="collapse" href="#collapseExampleCoupan" role="button" aria-expanded="false" aria-controls="collapseExample">
                            <span class="mt-1">Coupan</span>
                            <button  class="btn border-0 pe-0" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-angle-right"></i>
                            </button>
                        </a>
                    </div>
                    {{--  bottom list of Coupan  --}}
                     <div class="col-12">
                        <div class="collapse border-0" id="collapseExampleCoupan">
                            <div class="card card-body bg-info border-0">
                                <ul class="list-unstyled list-group border-0">
                                    <li class="list-group-item p-0 border-bottom border-0 bg-info"><a class="nav-link text-dark increaseTextSize" href="{{route('Coupan.create')}}">Add new</a></li>
                                    <li class="list-group-item p-0 border-bottom rounded-0 border-0 bg-info"><a class="nav-link text-dark increaseTextSize" href="{{route('Coupan.index')}}">Check All</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                {{--  orders  --}}
                <div class="row mt-2 p-0">
                    <div class="col-2  align-content-center">
                        <i class="fa-brands fa-first-order" style="font-size: 19px"></i>
                    </div>
                    <div class="col-8  align-content-center hidea d-inline">
                        <a class="nav-link text-dark d-inline" href="{{route('AllOrders')}}">Orders</a>
                    </div>
                </div>
                
                {{--  users  --}}
                <div class="row mt-2 usr" >
                    <div class="col-2  align-content-center u1 hidea d-inline">
                        <a class="nav-link text-dark" href="{{route('user')}}">
                            <i class="fa-solid fa-user" style="font-size: 19px"></i>
                        </a>
                    </div>
                    <div class="col-10 align-content-center hidea d-inline u2">
                        <a class="nav-link text-dark d-flex justify-content-between" onclick=ChangeColorClick(event) data-bs-toggle="collapse" href="#collapseExample5" role="button" aria-expanded="false" aria-controls="collapseExample">
                            <span class="mt-1">Users</span>
                            <button  class="btn border-0 pe-0" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-angle-right"></i>
                            </button>
                        </a>
                    </div>
                     {{--  bottom list of users  --}}
                     <div class="col-12">
                        <div class="collapse border-0" id="collapseExample5">
                            <div class="card card-body bg-info border-0">
                                <ul class="list-unstyled list-group border-0">
                                    <li class="list-group-item p-0 border-bottom border-0 bg-info"><a class="nav-link text-dark increaseTextSize" href="{{route('user')}}">Add new</a></li>
                                    <li class="list-group-item p-0 border-bottom rounded-0 border-0 bg-info"><a class="nav-link text-dark increaseTextSize" href="{{route('Allusers')}}">Check All</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                {{--  pages  --}}
                <div class="row mt-2 pages">
                    <div class="col-2 align-content-center p1 hidea d-inline">
                        <a class="nav-link text-dark">
                            <i class="fa-solid fa-copyright" style="font-size: 19px;"></i>
                        </a>
                    </div>
                    <div class="col-10 align-content-center hidea d-inline p2">
                        <a class="nav-link text-dark d-flex justify-content-between" onclick=ChangeColorClick(event) data-bs-toggle="collapse" href="#collapseExamplePages" role="button" aria-expanded="false" aria-controls="collapseExamplePages">
                            <span class="mt-1">Pages</span>
                            <button  class="btn border-0 pe-0" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-angle-right"></i>
                            </button>
                        </a>
                    </div>
                    {{--  bottom list of pages  --}}
                     <div class="col-12">
                        <div class="collapse border-0" id="collapseExamplePages">
                            <div class="card card-body bg-info border-0">
                                <ul class="list-unstyled list-group border-0">
                                    <li class="list-group-item p-0 border-bottom border-0 bg-info"><a class="nav-link text-dark increaseTextSize" href="{{route('Pages.create')}}">Add new</a></li>
                                    <li class="list-group-item p-0 border-bottom rounded-0 border-0 bg-info"><a class="nav-link text-dark increaseTextSize" href="{{route('Pages.index')}}">Check All</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                {{--  user questions  --}}
                <div class="row mt-3 p-0">
                    <div class="col-2 align-content-center">
                        <a class="nav-link text-dark d-inline" href="{{route('Questions')}}">
                            <i class="fa-solid fa-circle-question" style="font-size: 19px"></i>
                        </a>
                    </div>
                    <div class="col-8 align-content-center hidea d-inline">
                        <a class="nav-link text-dark d-inline" href="{{route('Questions')}}">User Questions</a>
                    </div>
                </div>
            </div>
            {{--  differnt in all pages  --}}
            <div class="col-xl-10 col-lg-9 col-sm-8 col-12" id="fullsize"
                style="overflow-y: scroll;height:100vh;padding-bottom:100px;">
                @section('MainPart')
                @show
            </div>
        </div>
    </div>
  
    <script src="{{ asset('bootstrap/js/jQuery.min.js') }}"></script>
    <script src="{{ asset('bootstrap/js/popper.min.js') }}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('bootstrap/js/all.js') }}"></script>
    <script src="{{ asset('Admin/js/base.js') }}"></script>
    <script src="{{ asset('webcam/webcam.js') }}"></script>
    <script src="{{ asset('select2/select2.min.js') }}"></script>
    <script src="{{ asset('summernote/summernote.min.js') }}"></script>
    <script src="{{ asset('dropzone/dist/dropzone-min.js') }}"></script>
    <script src="{{ asset('cropper/cropper.min.js') }}"></script>
    <script src="{{ asset('datetimepicker/jquery.datetimepicker.full.min.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).ready(function(){
            $(".summernote").summernote({
                height:250,
            });
        })
    </script>
    @section('CustomAction')@show
    @section("ckeditor")@show
    @section("dropZoneImages")@show
    @section('relateddata')@show
</body>
</html>