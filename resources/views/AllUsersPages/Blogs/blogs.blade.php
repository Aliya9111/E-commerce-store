@extends("AllUsersPages.layouts.topBar")
@section("UserStyleSheet")
    <link href="{{asset('AllUsers/css/BlogContact.css')}}" rel="stylesheet">
@show
@section('timeName','Blogs')

@section('row 2')
<div class="row mb-3 ms-lg-4 ms-sm-2 ms-1 me-lg-4 me-sm-2 me-1" style="margin-top:10px; ">
    <div class="col-12 border" style="background-color: rgb(243, 243, 243);">
        <nav aria-label="breadcrumb" class="" style="transform: translateY(5px)">
            <ol class="breadcrumb bg-transparent">
                <li class="breadcrumb-item"><a href="{{asset(route('Home'))}}" class="">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Blog</li>
            </ol>
        </nav>
    </div>
</div>
        
@endsection

@section('row 3')
    <div class="row ms-lg-4 ms-sm-2 ms-1 me-lg-4 me-sm-2 me-1 pb-4 CommonLighColor mt-3">
        <h1 class="text-center headingShadow mt-2">General</h1>
        <div class="col-lg-8 col-12 ">
            <div class="row mt-3 justify-content-center">
                @for ($i = 0; $i < 12; $i++)
                <div class="col-md-4 col-sm-5 col-10 mt-3">
                    <div class="card CommonLighColor border-0" >
                        <img src="{{asset('AllUsers\images\electronicsImg.jpg')}}" class="card-img-top img-fluid" alt="...">
                        <div class="card-body p-0 blogsCard mt-1">
                            <div style="font-size: 15px;" class="">General</div>
                            <div class="card-text" style="text-transform: capitalize;font-size:20px">Some quick example text to build on the card title.</div>
                            <time datetime="Sep 25 2023" style="font-size: 13px;border-bottom:1px solid black;">
                                Sep 25 2023
                            </time>
                        </div>
                      </div>
                </div>
                @endfor
               
            </div>
            <div class="position-relative border border-1 border-opacity-50 mt-4 " style="width:100%;">
                <div class="border border-2 mt-1 position-absolute bg-light h-10 w-10 rounded-circle" style="top:-20px;right:50%;transform:rotate(90deg);">
                    <i class="fa-solid fa-angle-right fs-3 m-1 d-block" style="color: rgb(131, 121, 121); height:20px ;width:20px"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-12" style="border:10px solid rgb(243, 243, 243);">
            <h4 class="mt-3">Popular Posts</h4>
            @for ($i = 0; $i < 5; $i++)
            <div class="d-flex mb-3" style="" >
                <div class="flex-shrink-0" style="height:100px;">
                    <img src="{{asset('AllUsers\images\electronicsImg.jpg')}}" alt="..." class="img-fluid blogTopMedia">
                </div>
                <div class="flex-grow-1 ms-3" style="height:100px;">
                    <div class="card-text mt-3" style="text-transform: capitalize;font-size:14px;font-weight:bold">Some quick example text to build on the card title.</div>
                    <time datetime="Sep 25 2023" style="font-size: 13px;border-bottom:1px solid black;">
                        Sep 25 2023
                      </time>
                </div>
            </div>
            @endfor
        </div>
    </div>    
@endsection