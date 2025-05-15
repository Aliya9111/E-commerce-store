@extends("AllUsersPages.layouts.topBar")
@section("UserStyleSheet")
    <link href="{{asset('AllUsers/css/profileCart.css')}}" rel="stylesheet">
    <style>
        .textSet{
            font-family: sans-serif;
            opacity: 0.9;
        }
        .textSize{
            font-size: 13px;
        }
        #formdataId > p{
            color:red;
            font-size: 13px;
            margin-bottom: 0px;
        }
        .fa-pen-small:hover{
            text-decoration-line: underline;
            text-decoration-color: blue;
        }
        {{--  .penUnderline{
            -webkit-box-reflect: below 2px;
        }  --}}
    </style>
@show
@section('timeName','Cart')

@section('row 2')
<div class="row mb-3 ms-lg-4 ms-sm-2 ms-1 me-lg-4 me-sm-2 me-1" style="margin-top:10px; ">
    <div class="col-12 border" style="background-color: rgb(243, 243, 243);">
        <nav aria-label="breadcrumb" class="" style="transform: translateY(5px)">
            <ol class="breadcrumb bg-transparent">
                <li class="breadcrumb-item"><a href="{{asset(route('Home'))}}" class="">Home</a></li>
                <li class="breadcrumb-item"><a href="{{route('ProductsLoad',['categoriId'=>$product->categories->id])}}" class="">{{$product->categories->cname}}</a></li>
                @isset($subCategory)
                    <li class="breadcrumb-item active" aria-current="page">{{$subCategory}}</li>
                @endisset
            </ol>
        </nav>
    </div>
</div>
@endsection

@section('row 3')
    {{--  percentage of all reviews  --}}
    @php
        $ratingsPer=App\Helper\Helper::ReviewsPercentage($product->id);
        $ratingsPer=number_format($ratingsPer,1);
    @endphp
    <div class="row mb-3 ms-lg-4 ms-sm-2 ms-1 me-lg-4 me-sm-2 me-1 justify-content-center ">
        <div class="col-md-6 col-12 d-flex">
            @if ($product_images->isNotEmpty())
                <div class="imgSamples">
                    @foreach ($product_images as $product_image)
                        <div id="images-{{$product_image->id}}" onclick="selectImg({{$product_image->id}})">
                            <img src="{{asset('Admin/images/products/uploads/'.$product_image->name)}}" class="img-fluid  h-100 w-100 object-fit-contain">
                        </div>
                    @endforeach
                </div>
            @endif
            <input type="hidden" value="{{!empty($product_images) ? $product_images[0]['id'] :null }}" name="imageIdInput" id="imageIdInputId">
            
            <div class="CartImg" style="height: 400px">
                @if ($product_images)
                    <img src="{{asset('Admin/images/products/uploads/'.$product_images[0]['name'])}}" id="imgProduct" class="w-100 h-100 img-fluid object-fit-contain" style="height: 150px;">
                @else
                    <img src="{{asset('AllUsers/images/no image.webp')}}" class="w-100 img-fluid object-fit-cover h-100">  
                @endif
            </div>
        </div>
        <div class="col-md-6 col-12 blogsCard CommonLighColor p-3" >
            <div class="d-flex">
                <h3 class="blogsCard" style="font-weight: bold">{{$product->title}}</h3>
                <ul class="list-unstyled d-flex gap-2 ms-auto position-relative">
                    @if (Auth::check())
                        @php
                            $FavProductCheck=App\Helper\Helper::SingleFavPro($product->id);
                        @endphp
                        @if ($FavProductCheck)
                            <li class="hotSear">
                                <div class="d-inline" style="top:5px;left:5px" onclick=AddRemoveFavourite(event,{{$product->id}})>
                                    <i class="fa-solid fa-heart  fs-5 text-warning"></i>
                                </div>
                            </li>
                        @else
                            <li class="hotSear">
                                <div class="d-inline" style="top:5px;left:5px" onclick=AddRemoveFavourite(event,{{$product->id}})>
                                    <i class="fa-regular fa-heart fs-5 text-warning" ></i>
                                </div>
                            </li>
                        @endif
                    @else
                        <li class="hotSear">
                            <div class="d-inline" style="top:5px;left:5px" onclick=AddRemoveFavourite(event,{{$product->id}})>
                                <i class="fa-regular fa-heart fs-5 text-warning" ></i>
                            </div>
                        </li>
                    @endif    
                    <li class="hotSear" id="hotSear"><i class="fa-solid fa-share-nodes hotSear"></i></li>
                    <ul class="position-absolute list-unstyled HeadText p-2 share d-none" style="top:20px; left:20px">
                        <a class="nav-link" href="https://www.facebook.com/profile.php?id=100074095516946" target="_blank">
                            Facebook
                        </a>
                        <li>whatsapp</li>
                        <li>
                            <a class="nav-link" href="https://www.instagram.com/aliyaijaz1/" target="_blank">
                                instagram
                            </a>
                        </li>
                    </ul>
                </ul>

            </div>
            @if ($brand)
                <p class="mb-0 smallHead" ><b>Brand:</b> <span class="HeadText">{{$brand->bname}}</span></p>
            @endif
            <ul class="list-unstyled mb-0">
                <li class="">
                    <li style="font-size: 15px;font-weight:bold;" class="me-2 d-inline">{{$ratingsPer}}</li>
                    <x-UserComp.ratings :ratingsPer="$ratingsPer" :fontSize="15"></x-UserComp.ratings>
                </li>
                <li>
                    <p class="blogsCard text-dark;font-size: 15px;">{!! $product->Description !!}</p>
                </li>
            </ul>
            <p style="color: rgb(42, 70, 212);font-weight:bold" class="mb-0">
                @if ($product->quantity>0)
                    In stock
                @else 
                    Out of stock   
                @endif
            </p>
            <span class="smallHead mb-0 "><b>Price:</b>
                <ul class="list-unstyled d-inline-flex gap-4">
                    <li class="HeadText"><b>Rs:</b>{{$product->price}}</li>
                    @if ($product->compare_price!=NULL)
                        <li class="HeadText" style="opacity: 0.5; text-decoration-line:line-through">Rs:{{$product->compare_price}}</li>
                    @endif
                </ul>
            </span>

            <p class="mt-0 mb-0"><b class="smallHead">Quantity:</b><span class="HeadText"> {{$product->quantity}}</span></p>
            <button class="btn border-0 w-100 mt-3 cartbtn mb-0" style="background-color: rgb(119, 133, 207);border-radius:10px" onclick="CartAdd({{$product->id}},document.getElementById('imageIdInputId').value)">
                @if ($product->quantity>0)
                    Add Cart
                @else
                    Add Cart
                    <script>
                        document.getElementsByClassName('cartbtn')[0].classList.add('disabled');
                    </script>
                @endif
            </button>
        </div>
    </div>
@endsection

@section('row 4')
    <div class="row mb-3 ms-lg-4 ms-sm-2 ms-1 me-lg-4 me-sm-2 me-1 CommonLighColor">
        <div class="col-12 d-flex justify-content-center text-center gap-5 p-3 blogsCard" onclick=ShowRewDes(event)>
            <div class="fs-6" id="des" style="font-weight: bold;font-size:14px;">
                Description
            </div>
            <div class="fs-6" id="Reviews" style="font-weight: bold;">
                Reviews
            </div>
        </div>
        <div class="col-12 d-inline textSet textSize" id="desDetail">
            <p class="bg-light p-2">
                {!! $product->Description !!}
            </p>
        </div>
        <div class="col-12 d-none textSet textSize" id="RevDetail">
            {{--  form of get reviews  --}}
            <div class="row ms-2">
                <div class="col-6 textSet textSize">
                    <h3 style="font-weight: bold;">Write a Review</h3>
                    <div id="userAlert"></div> {{-- error show if user already comment on product  --}}
                    <form method="post" onsubmit="RatingSave(event)" id="formdataId">
                        @csrf
                        <label class="mt-2 mb-1">Name:</label>
                        <input type="text" name="name" id="nameidInput" class="form-control textSet textSize">
                        <p id="nameidP"></p>
                        
                        <label class="mt-2 mb-1">Email:</label>
                        <input type="email" id="emailidInput" name="email" class="form-control textSet textSize">
                        <p id="emailidP"></p>
                        
                        <label class="mt-2 mb-1">Rating:</label><br>
                        <div id="ratings" >
                            <input type="radio" id="1" name="ratings" class="d-none" value="1">
                            <label id="rating-1" class="fa-regular fa-star text-warning" style="font-size: 15px;" onclick="CheckRatingsBox(event)"></label>
                        
                            <input type="radio" id="2" name="ratings" class="d-none" value="2">
                            <label id="rating-2" class="fa-regular fa-star text-warning" style="font-size: 15px;" onclick="CheckRatingsBox(event)"></label>
                        
                            <input type="radio" id="3" name="ratings" class="d-none" value="3">
                            <label id="rating-3" class="fa-regular fa-star text-warning" style="font-size: 15px;" onclick="CheckRatingsBox(event)"></label>
                        
                            <input type="radio" id="4" name="ratings" class="d-none" value="4">
                            <label id="rating-4" class="fa-regular fa-star text-warning" style="font-size: 15px;" onclick="CheckRatingsBox(event)"></label>
                        
                            <input type="radio" id="5" name="ratings" class="d-none" value="5">
                            <label id="rating-5" class="fa-regular fa-star text-warning" style="font-size: 15px;" onclick="CheckRatingsBox(event)"></label>
                        </div>
                        <p id="ratingsidP"></p>
                        
                        <label class="mt-2 mb-1">Comment:</label>
                        <textarea class="form-control" cols="15" id="commentsidInput" name="comments"></textarea>
                        
                        <p id="commentsidP"></p>
                        <button type="submit" class="btn btn-primary mt-3 btn-sm mb-3">Submit</button>
                    </form>
                </div>
            </div>
            
            @if ($produtRatings->isNotEmpty())
                
                <div>
                    <ul class="list-unstyled d-flex mt-1 ms-2">
                        <li style="font-size: 21px;font-weight:bold;" class="me-2">{{$ratingsPer}}</li>
                        <x-UserComp.ratings :ratingsPer="$ratingsPer" :fontSize="20"></x-UserComp.ratings>
                        <li class="mt-1 ms-2">{{count($produtRatings)}}
                            {{count($produtRatings) > 1 ? ' (Reviews)' : ' (Review)'}}</li>
                    </ul>
                </div>
                @foreach ($produtRatings as $produtRating)
                    @php
                        $userRecord=App\Models\User::find($produtRating->user_id);
                    @endphp
                    
                    <div id="commentsDel-{{$produtRating->id}}">
                        <div class="ms-2 d-flex">
                            <div style="max-height:50px; max-width:50px;">
                                @if ($userRecord->image)
                                    <img src="{{asset($userRecord->image)}}" class="profileImg rounded-circle img-fluid object-fit-cover" style="max-height:100%;max-width:100%">
                                @else
                                    <img src="{{asset('images/profile.jfif')}}" class="profileImg rounded-circle img-fluid object-fit-cover" style="max-height:100%;max-width:100%">
                                @endif
                            </div>
                            <div class="ms-2 align-content-center">
                                <span class="text-center blogsCard">{{$userRecord->name}}</span>
                            </div>
                        </div>
                        <div class="pb-4 ps-2 pt-1 pb-0 ">
                            <ul class="list-unstyled  mb-0">
                                <li style="font-size: 15px;" id="Comment-{{$produtRating->id}}">
                                    <small class="fa-regular fa-star text-warning" id="1-{{$produtRating->user_id}}"></small>
                                    <small class="fa-regular fa-star text-warning" id="2-{{$produtRating->user_id}}"></small>
                                    <small class="fa-regular fa-star text-warning" id="3-{{$produtRating->user_id}}"></small>
                                    <small class="fa-regular fa-star text-warning" id="4-{{$produtRating->user_id}}"></small>
                                    <small class="fa-regular fa-star text-warning" id="5-{{$produtRating->user_id}}"></small>
                                    @if (Auth::check())
                                        @if (Auth::id()==$produtRating->user_id)
                                            <small style="font-size: 13px;margin-start:5px" onclick="deleteComment({{$produtRating->id}})"><i class="fa-solid fa-trash text-danger"></i></small>
                                            <small style="font-size: 13px" class="fa-pen-small" onclick="updateComment({{$produtRating->id}})">
                                                <i class="fa-solid fa-pen text-primary penUnderline"></i>
                                            </small>
                                        @endif
                                    @else
                                        <small style="font-size: 13px ;margin-start:5px" onclick="deleteComment({{$produtRating->id}})"><i class="fa-solid fa-trash"></i></small>
                                        <small style="font-size: 13px" class="fa-pen-small"  onclick="updateComment({{$produtRating->id}})"><i class="fa-solid fa-pen"></i></small>
                                    @endif
                                    <p class="blogsCard text-dark textSize" >{{$produtRating->comments }}</p>
                                   
                                </li>
                                <script>
                                    var rating={{$produtRating->ratings}}
                                    for(var j=1; j<=parseInt(rating); j++){
                                        console.log(jQuery("#"+j+"-"+{{$produtRating->user_id}}))
                                        jQuery("#"+j+"-"+{{$produtRating->user_id}}).addClass('fa-solid');
                                    }
                                </script>
                            </ul>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
    {{--  <!-- Modal -->  --}}
    <div class="modal fade" id="ReviewModal" tabindex="-1" aria-labelledby="ReviewModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="ReviewModalLabel">Modal title</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="ReviewModalBody">
            ...
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="messagebtn" data-bs-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
    </div>
@endsection

@if (!empty($bestSellingProducts))
    @section('row 5')
    {{--  show related products  --}}
    <div class="row mt-3 mb-3 ms-lg-4 ms-sm-2 ms-1 me-lg-4 me-sm-2 me-1 p-3 pb-4 CommonLighColor justify-content-sm-start justify-content-center">
        <h3 class="headingShadow">Best Selling Products</h3>
        <hr style="border:2px solid hsl(230, 48%, 64%) ">
        @foreach($bestSellingProducts as $bestSellProduct)
            @php
                $ProductsImage=$bestSellProduct->productImages()->first();
                $imagePrductId=null;
                $ratingsPer=App\Helper\Helper::ReviewsPercentage($bestSellProduct->id);
                $ratingsPer=number_format($ratingsPer,1);
            @endphp
            <div class="col-xl-2 col-lg-3 col-md-4 col-6 mb-4" id="fullWidth">
                <div class="card" style="" id="category" style="max-width: 100%;max-height:100%;">
                    <div class="position-relative" id="showHideChild">
                        @if ($ProductsImage)
                            <img src="{{asset('Admin/images/products/uploads/'.$ProductsImage->name)}}" class="w-100 img-fluid object-fit-cover" style="height: 150px;">
                            @php
                                $imagePrductId=$ProductsImage->id;
                            @endphp
                            @else
                            <img src="{{asset('AllUsers/images/no image.webp')}}" class="w-100 img-fluid object-fit-cover" style="height: 150px;">  
                        @endif
                       
                        @if ($bestSellProduct->quantity>0)
                            <div class="position-absolute bg-dark p-2 cartAdd d-flex" onclick="CartAdd({{$bestSellProduct->id}},{{$imagePrductId}}'))">
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
                                $FavProductCheck=App\Helper\Helper::SingleFavPro($bestSellProduct->id);
                            @endphp
                            @if ($FavProductCheck)
                                <div class="position-absolute d-inline text-light" style="top:5px;left:5px" onclick=AddRemoveFavourite(event,{{$bestSellProduct->id}})>
                                    <i class="fa-solid fa-heart  fs-5 text-warning"></i>
                                </div>
                        @else
                            <div class="position-absolute d-inline text-light" style="top:5px;left:5px" onclick=AddRemoveFavourite(event,{{$bestSellProduct->id}})>
                                <i class="fa-regular fa-heart fs-5 text-warning" ></i>
                            </div>
                        @endif
                    @else
                        <div class="position-absolute d-inline text-light" style="top:5px;left:5px" onclick=AddRemoveFavourite(event,{{$bestSellProduct->id}})>
                            <i class="fa-regular fa-heart fs-5 text-warning" ></i>
                        </div>   
                    @endif
                    </div>
                    
                    <div class="card-body" style="font-size: 12px;cursor: pointer;" onclick="window.location.href='{{route('CartProduct',$bestSellProduct->id)}}'">
                        <p class="card-text " >{{$bestSellProduct->title}}</p>
                        <ul class="list-unstyled d-flex gap-5 mb-0">
                            <li><b>Rs. {{$bestSellProduct->price}}</b></li>
                            @if ($bestSellProduct->compare_price)
                                <li style="text-decoration:line-through;opacity:0.5;" id="starPer">Rs .{{$bestSellProduct->compare_price}}</li>
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
    @endsection
@endif
@if (!empty($related_products))
    @section('row 6')
        {{--  show related products  --}}
        <div class="row mt-3 mb-3 ms-lg-4 ms-sm-2 ms-1 me-lg-4 me-sm-2 me-1 p-3 pb-4 CommonLighColor justify-content-sm-start justify-content-center">
            <h3 class="headingShadow">Related Products</h3>
            <hr style="border:2px solid hsl(230, 48%, 64%) ">
            @foreach($related_products as $related_product)
                @php
                    $ProductsImage=$related_product->productImages()->first();
                    $imagePrductId=null;
                    $ratingsPer=App\Helper\Helper::ReviewsPercentage($related_product->id);
                    $ratingsPer=number_format($ratingsPer,1);
                @endphp
                <div class="col-xl-2 col-lg-3 col-md-4 col-6 mb-4" id="fullWidth">
                    <div class="card" style="" id="category" style="max-width: 100%;max-height:100%;">
                        <div class="position-relative" id="showHideChild">
                            @if ($ProductsImage)
                                <img src="{{asset('Admin/images/products/uploads/'.$ProductsImage->name)}}" class="w-100 img-fluid object-fit-cover" style="height: 150px;">
                                @php
                                    $imagePrductId=$ProductsImage->id;
                                @endphp
                                @else
                                <img src="{{asset('AllUsers/images/no image.webp')}}" class="w-100 img-fluid object-fit-cover" style="height: 150px;">  
                            @endif
                        
                            @if ($related_product->quantity>0)
                                <div class="position-absolute bg-dark p-2 cartAdd d-flex" onclick="CartAdd({{$related_product->id}},{{$imagePrductId}}'))">
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
                                    $FavProductCheck=App\Helper\Helper::SingleFavPro($related_product->id);
                                @endphp
                                @if ($FavProductCheck)
                                    <div class="position-absolute d-inline text-light" style="top:5px;left:5px" onclick=AddRemoveFavourite(event,{{$related_product->id}})>
                                        <i class="fa-solid fa-heart  fs-5 text-warning"></i>
                                    </div>
                            @else
                                <div class="position-absolute d-inline text-light" style="top:5px;left:5px" onclick=AddRemoveFavourite(event,{{$related_product->id}})>
                                    <i class="fa-regular fa-heart fs-5 text-warning" ></i>
                                </div>
                            @endif
                        @else
                            <div class="position-absolute d-inline text-light" style="top:5px;left:5px" onclick=AddRemoveFavourite(event,{{$related_product->id}})>
                                <i class="fa-regular fa-heart fs-5 text-warning" ></i>
                            </div>   
                        @endif
                        </div>
                        
                        <div class="card-body" style="font-size: 12px;cursor: pointer;" onclick="window.location.href='{{route('CartProduct',$related_product->id)}}'">
                            <p class="card-text " >{{$related_product->title}}</p>
                            <ul class="list-unstyled d-flex gap-5 mb-0">
                                <li><b>Rs. {{$related_product->price}}</b></li>
                                @if ($related_product->compare_price)
                                    <li style="text-decoration:line-through;opacity:0.5;" id="starPer">Rs .{{$related_product->compare_price}}</li>
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
    @endsection
@endif

@section("ActionSheet")
    <script src="{{asset('AllUsers/js/cart.js')}}"></script>
    <script>
        var starCheckdIdArray=[1];

        @if($product_images!=null)
            var divImgIdTag_1={{$product_images[0]['id']}}
            var divImgTag_1=document.getElementById("images-"+divImgIdTag_1);
            divImgTag_1.classList.add("border","border-3")
            function selectImg(id){
                let divImgIdTagEvent=document.getElementById("images-"+id);
                let imgsrc=divImgIdTagEvent.firstElementChild.src;
                document.getElementById("imgProduct").src=imgsrc
                divImgIdTagEvent.classList.add("border","border-3")
                document.getElementById('imageIdInputId').value=id;
                @foreach ($product_images as $product_image)
                    if(document.getElementById("images-"+{{$product_image->id}}).id!=divImgIdTagEvent.id){
                        document.getElementById("images-"+{{$product_image->id}}).classList.remove("border","border-3")
                    }
                @endforeach
            }
        @endif
        function CheckRatingsBox(e){
            var startLabelId='';
            var startLabelParenetNode=event.target.parentNode;
            if(startLabelParenetNode.nodeName=='DIV'){
                startLabelId=event.target.id;
            }
            else{
                startLabelId= startLabelParenetNode.id;
            }
            var ratingNumber=startLabelId.split('-').pop();
            var radioInput = document.getElementById(ratingNumber);
            document.getElementById(ratingNumber).checked=true;
            var preValue=starCheckdIdArray.pop();
            starCheckdIdArray.push(ratingNumber);
            if(preValue <= parseInt(ratingNumber)){
                for(var i=preValue; i <= parseInt(ratingNumber); i++){
                    jQuery("#rating-"+i).addClass('fa-solid')
                }
            }
            else{
                for(var i=preValue; i >= parseInt(ratingNumber)+1; i--){
                    jQuery("#rating-"+i).addClass('fa-regular')
                }
            }
        }    
        function RatingSave(event){
            event.preventDefault();
            var form=document.getElementById("formdataId");
            console.log(form);

            {{--  var ReviewsData=new FormData(form);  --}}
            var ReviewsData=jQuery("#formdataId").serializeArray();
            console.log(ReviewsData);

            @if(Auth::check())
                ReviewsData.push({name:'userId',value:{{Auth::id()}}});
                ReviewsData.push({name:'productId',value:{{$product->id}}});
            @else 
                ReviewsData.push({name:'userId',value:null});
                ReviewsData.push({name:'productId',value:null});
            @endif
            console.log(ReviewsData)

            jQuery.ajax({
                url:"{{route('RatingsStore')}}",
                type:'post',
                data:ReviewsData,
                dataType:'json',
                success:function(response){
                    if(response.status==false){
                        let errorMessage=   `<div class="alert alert-danger">
                                                <strong>Fail! </strong>${response.message}
                                                <a href={{route("login")}}>Login</a>
                                            </div>`
                        jQuery("#ReviewModalBody").html(errorMessage)
                        var model=new bootstrap.Modal(jQuery("#ReviewModal")).show()
                    }
                    if(response.status==true){
                        let successMessage=  `<div class="alert alert-success">
                                                <strong>Success! </strong>${response.message}
                                            </div>`
                        jQuery("#ReviewModalBody").html(successMessage)
                        document.getElementById("messagebtn").addEventListener('click',()=>{window.location.reload()})
                        var model=new bootstrap.Modal(jQuery("#ReviewModal")).show()

                    }
                    {{--  show error id user alreay post comment  --}}
                    if(response.status=="userAlreadyComment"){
                        let alertMessage=`<div class="alert alert-danger d-flex" role="alert">
                                                <div>
                                                    You already post a review
                                                </div>
                                            </div>
                        `
                        jQuery("#userAlert").html("");
                        jQuery("#userAlert").html(alertMessage);
                    }
                    {{--  show the errors  --}}
                    if(response.status==true || response.status == 'validationFail'){
                        var errors=response.errors;
                        if(errors.name){
                            jQuery("#nameidInput").addClass("is-invalid");
                            jQuery("#nameidP").text(errors.name);
                        }
                        else{
                            jQuery("#nameidInput").removeClass("is-invalid");
                            jQuery("#nameidP").text("");
                        }
                        if(errors.email){
                            jQuery("#emailidInput").addClass("is-invalid");
                            jQuery("#emailidP").text(errors.email);
                        }
                        else{
                            jQuery("#emailidInput").removeClass("is-invalid");
                            jQuery("#emailidP").text("");
                        }                        
                        if(errors.ratings){
                            jQuery("#ratingsidInput").addClass("is-invalid");
                            jQuery("#ratingsidP").text(errors.ratings);
                        }
                        else{
                            jQuery("#ratingsidInput").removeClass("is-invalid");
                            jQuery("#ratingsidP").text("");
                        }                        
                        if(errors.comments){
                            jQuery("#commentsidInput").addClass("is-invalid");
                            jQuery("#commentsidP").text(errors.comments);
                        }
                        else{
                            jQuery("#commentsidInput").removeClass("is-invalid");
                            jQuery("#commentsidP").text("");
                        }
                    }
                }

            });
        }
        function updateComment(id){
            console.log(id)
            jQuery.ajax({
                url:"{{route('updateComment',':id')}}".replace(':id',id),
                type:'get',
                dataType:'json',
                success:function(response){
                    if(response.status==false){
                        let errorMessage=`<div class="alert alert-danger">
                                            <strong>Fail! </strong>${response.message}
                                            <a href={{route("login")}}>Login</a>
                                        </div>`
                        jQuery("#ReviewModalBody").html(errorMessage)
                        var model=new bootstrap.Modal(jQuery("#ReviewModal")).show()
                    }
                    if(response.status=='UnauthorizeUser'){
                        var errorMessage=`<div class="alert alert-danger">
                                            <strong>Fail! </strong>${response.message}
                                        </div>`
                        jQuery("#ReviewModalBody").html(errorMessage)
                        var model=new bootstrap.Modal(jQuery("#ReviewModal")).show()
                    }
                    if(response.status==true){
                        var createForm=`<div>
                                            <form method="post" id="updateFormComment" onsubmit="UpdateSaveComment(event,${response.Review['id']})" class="w-100">
                                                @csrf
                                                @method('patch')
                                                <textarea name='comments' value=${response.Review['comments']} class="form-control" style="height:100px;"></textarea>
                                                <p class="text-danger" style="font-size:13px;font-family:sans-serif;" id="updateCommId"></p>
                                                <button type="submit" class="btn btn-primary btn-sm mt-2">Update</button>
                                                <button class="btn btn-success btn-sm mt-2 ms-1" onclick="cancelUpdate(${response.Review['id']})">Cancel</button>
                                            </form>
                                        </div>
                                        `
                        var ulCommentTag=document.getElementById("Comment-"+response.Review['id'])
                        ulCommentTag.removeChild(ulCommentTag.lastElementChild)
                        console.log(ulCommentTag)
                        ulCommentTag.insertAdjacentHTML("beforeend",createForm)
                    }
                }
            });

        }
        function UpdateSaveComment(event,id){
            event.preventDefault();
            console.log(event.target);
            console.log(id);
            var formComment=jQuery("#updateFormComment").serializeArray();

            jQuery.ajax({
                url:"{{route('SaveComment',':id')}}".replace(':id',id),
                type:'patch',
                data:formComment,
                dataType:'json',
                success:function(response){
                    var errors=response.errors;
                    if(errors.comments){
                        jQuery("#updateCommId").text(errors.comments);
                    }
                    else{
                        jQuery("#updateCommId").text("");

                    }
                    if(response.status==true){
                        var pComment=`<p class="blogsCard text-dark textSize" >${response.review['comments']}</p>`
                        var ulCommentTag=document.getElementById("Comment-"+response.review['id'])
                        ulCommentTag.removeChild(ulCommentTag.lastElementChild)
                        console.log(ulCommentTag)
                        ulCommentTag.insertAdjacentHTML("beforeend",pComment)
                    }

                }
            });

        }
        function deleteComment(id){
            if(confirm('Are you sure for delete this comment')){
                jQuery.ajax({
                    url:"{{route('deleteComment',':id')}}".replace(':id',id),
                    type:'delete',
                    dataType:'json',
                    success:function(response){
                        if(response.status==false){
                            let errorMessage=`<div class="alert alert-danger">
                                                <strong>Fail! </strong>${response.message}
                                                <a href={{route("login")}}>Login</a>
                                            </div>`
                            jQuery("#ReviewModalBody").html(errorMessage)
                            var model=new bootstrap.Modal(jQuery("#ReviewModal")).show()
                        }
                        if(response.status=='UnauthorizeUser'){
                            var errorMessage=`<div class="alert alert-danger">
                                                <strong>Fail! </strong>${response.message}
                                            </div>`
                            jQuery("#ReviewModalBody").html(errorMessage)
                            var model=new bootstrap.Modal(jQuery("#ReviewModal")).show()
                        }
                        if(response.status==true){
                            var commentDelete=document.getElementById("commentsDel-"+response.review['id']);
                            console.log(response.review['id'])
                            commentDelete.parentNode.removeChild(commentDelete);
                        }
                    }
                });
            }
            

        }
    </script>
@endsection