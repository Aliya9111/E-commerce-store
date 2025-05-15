@extends('AllUsersPages.layouts.topBar')
@section("UserStyleSheet")
    <link href="{{asset('AllUsers/css/ProductsAbout.css')}}" rel="stylesheet">
@show
@section('timeName','Products')

@section('row 2')
<div class="row mb-3 ms-lg-4 ms-sm-2 ms-1 me-lg-4 me-sm-2 me-1" style="margin-top:10px; ">
    <div class="col-12 border" style="background-color: rgb(243, 243, 243);">
        <nav aria-label="breadcrumb" class="" style="transform: translateY(5px)">
            <ol class="breadcrumb bg-transparent">
                <li class="breadcrumb-item"><a href="{{asset(route('Home'))}}" class="">Home</a></li>
                @if (!empty($category))
                    <li class="breadcrumb-item active" aria-current="page">{{$category->cname}}</li>
                @endif
            </ol>
        </nav>
    </div>
</div>
        
@endsection

@section('row 3')

    <div class="row ms-lg-4 ms-sm-2 ms-1 me-lg-4 me-sm-2 me-1 justify-content-between"> 
        <div class="position-fixed btn-group fixedButton d-sm-inline d-none">
            <button class="btn" onclick="ApplyFilters(event)" style="background-color: rgb(119, 133, 207);">Check</button>
            <button class="btn" style="background-color: rgba(250, 250, 14, 0.74);" onclick="window.location.href='{{route('ProductsLoad',['categoriId'=>!empty($category) ? $category->id :'0'])}}'">Clear filters</button>
        </div> 
        <div class="col-lg-3 col-sm-4 d-sm-inline d-none p-0">
            <div class="divProductBack p-2 position-relative" >
                <p class="text-center bold filtersSet pe-2" >Filters</p>
                @if (!empty($category))
                    <h6 class="" style="margin-top:-10px"><b>Category Name</b></h6>
                    <div class="form-check">
                        <label class="form-check-label">{{$category->cname}}<span class="opacity-50">(4)</span></label><br>
                    </div>
                    @php
                        $subCategories=$category->Subcategories()->orderBy('sname','asc')->get();
                    @endphp
                    @if($subCategories->isNotEmpty())
                            <h6 class="" style="margin-top:10px"><b>Subcategory Names</b></h6>
                            <div class="form-check" onclick=sucategory(event)>
                                @foreach ($subCategories as $subCategory)
                                    @if (empty($splitSubcategories))
                                        @if (!empty($SubcategroyId))
                                            <input type="checkbox" {{$subCategory->id==$SubcategroyId ? 'checked':''}} name="subcategory"  class="form-check-input" data-id={{$subCategory->id}}>
                                        @else
                                            <input type="checkbox"  name="subcategory"  class="form-check-input" class="form-check-input" data-id={{$subCategory->id}}>
                                        @endif
                                        <label class="form-check-label">{{$subCategory->sname}}<span class="opacity-50">(4)</span></label><br>
                                    @else 
                                    <input type="checkbox" {{in_array($subCategory->id,$splitSubcategories) ? 'checked':''}} name="subcategory"  class="form-check-input" data-id={{$subCategory->id}}>
                                    <label class="form-check-label">{{$subCategory->sname}}<span class="opacity-50">(4)</span></label><br>
                                    @endif
                                   
                                @endforeach
                            </div>
                    @endif
                @endif

            </div>
            @if($brands->isNotEmpty())
                <div class="divProductBack mt-4 p-2 position-relative">
                    <h6><b>Brands</b></h6>
                    <div class="form-check" onclick=brands(event)>
                        @if (!empty($splitBrands))
                            @foreach ($brands as $brand)
                                <input type="checkbox" {{in_array($brand->id,$splitBrands) ? 'checked' : ''}} class="form-check-input" data-brand={{$brand->id}}>
                                <label class="form-check-label">{{$brand->bname}}</label><br>
                            @endforeach 
                            
                            @else
                            
                            @foreach ($brands as $brand)
                                <input type="checkbox" class="form-check-input" data-brand={{$brand->id}}>
                                <label class="form-check-label">{{$brand->bname}}</label><br>
                            @endforeach 
                        @endif
                        
                    </div>
                </div>
            @endif
            <div class="divProductBack mt-4 p-2 position-relative">
                <h6><b>Price</b></h6>
                <div class="">
                    <input class="form-control mb-2" type="number" id="minPrice" placeholder="Min Value" min="{{$minPrice}}" max="{{$maxPrice}}" value="{{$minPrice}}" name="minValue"></input>
                    <input class="form-control" type="number" id="maxPrice" placeholder="Max Value" min="{{$minPrice}}" max="{{$maxPrice}}" value="{{$maxPrice}}" name="maxValue"></input>
                </div>
            </div>
        </div>
        <div class="col-lg-9 col-sm-8 col-12 pt-2 pb-5 productsShopRight" style=" ">
            <div class="row">
                <div class="col-12 d-flex">
                    <h3 class="headingShadow">Products
                        <a class="btn btn-dark btn-sm text-light d-sm-none d-inline"  style="font-weight: bold;" data-bs-toggle="offcanvas" href="#offcanvasScrolling2" aria-controls="offcanvasScrolling2">
                            Filters
                        </a>
                    </h3>
                    <select name="selectOption" id="selectOptionId" onchange="ApplyFilters(event)" class="form-select ms-auto selefilter">
                        <option value="Latest" selected>Latest</option>
                        <option value="Oldest">Oldest</option>
                        <option value="HighPrice">High Price</option>
                        <option value="LowPrice">Low Price</option>
                        <option value="Ascending">Ascending Order</option>
                        <option value="Descending">Descending Order</option>
                    </select>
                 
                </div>
               
            </div>
            <hr style="border:2px rgb(47, 72, 197) solid " class="mt-0">
            {{--  row 5  --}}
            {{--  show the products  --}}
            <div class="row mt-3 mb-3 ms-lg-4 ms-sm-2 ms-1 me-lg-4 me-sm-2 me-1 p-3 CommonLighColor justify-content-sm-start justify-content-center" id="showAllProducts">
                @if($products->isNotEmpty())
                    @foreach($products as $product)
                        @php
                            $productImages=$product->productImages()->first();
                            $imagePrductId=null;
                            $ratingsPer=App\Helper\Helper::ReviewsPercentage($product->id);
                            $ratingsPer=number_format($ratingsPer,1);
                        @endphp
                        <div class="col-xl-3 col-lg-4 col-md-5  col-9 mb-4">
                            <div class="card" style="" id="category" style="max-width: 100%;max-height:100%;">
                                <div class="position-relative" id="showHideChild">
                                    @if (!empty($productImages))
                                        <img src="{{asset('Admin/images/products/uploads/'.$productImages->name)}}" class="w-100 img-fluid object-fit-cover" style="height: 150px;">
                                        @php
                                            $imagePrductId=$productImages->id;
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
                                
                                <div class="card-body pSize" style="font-size: 12px;cursor: pointer;"  onclick="window.location.href='{{route('CartProduct',$product->id)}}'">
                                    <p class="card-text " >{{$product->title}}</</p>
                                    <ul class="list-unstyled d-flex gap-5 mb-0">
                                        <li><b>Rs. {{$product->price}}</b></li>
                                        @if ($product->compare_price)
                                            <li style="text-decoration:line-through;opacity:0.5;" id="starPer">Rs .{{$product->compare_price}}</li>
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
                    @else
                        <div class="col-12">
                            <h3 class="text-center opacity-25">
                                No product available
                            </h3>
                        </div>
                @endif
            </div>
            
        </div>
        {{--  open filter when click on filter button --}}
        <div class="offcanvas offcanvas-start d-sm-none d-inline p-0" data-bs-scroll="true" tabindex="-1" id="offcanvasScrolling2" aria-labelledby="offcanvasScrollingLabel2" data-bs-scroll="true">
            <div class="offcanvas-header pt-2 pb-2 position-sticky top-0" style="background-color: rgb(89, 111, 219);">
                <h5 class="offcanvas-title ms-auto " id="offcanvasScrollingLabel2">Filters</h5>
                <button type="button" class="btn-close me-2" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            
            <div class="offcanvas-body ms-sm-2 ms-0 pb-3">
                <div class="btn-group fixedButton2">
                    <button class="btn" onclick="ApplyFilters(event)" style="background-color: rgb(119, 133, 207);">Check</button>
                    <button class="btn" style="background-color: rgba(250, 250, 14, 0.74);" onclick="window.location.href='{{route('ProductsLoad',['categoriId'=>!empty($category) ? $category->id :'0'])}}'">Clear</button>
            </div>
            <div class="divProductBack p-2" style="margin-top:40px;">
                <p class="text-center bold filtersSet pe-2" >Filters</p>
                @if (!empty($category))
                    <h6 class="" style="margin-top:-10px"><b>Category Name</b></h6>
                    <div class="form-check">
                        <label class="form-check-label">{{$category->cname}}<span class="opacity-50">(4)</span></label><br>
                    </div>
                    @php
                        $subCategories=$category->Subcategories()->orderBy('sname','asc')->get();
                    @endphp
                    @if($subCategories->isNotEmpty())
                        <h6 class="" style="margin-top:10px"><b>Subcategory Names</b></h6>
                        <div class="form-check" onclick=sucategory(event)>
                            @foreach ($subCategories as $subCategory)
                                @if (empty($splitSubcategories))
                                    @if (!empty($SubcategroyId))
                                        <input type="checkbox" {{$subCategory->id==$SubcategroyId ? 'checked':''}} name="subcategory"  class="form-check-input" data-id={{$subCategory->id}}>
                                    @else
                                        <input type="checkbox"  name="subcategory"  class="form-check-input" class="form-check-input" data-id={{$subCategory->id}}>
                                    @endif
                                    <label class="form-check-label">{{$subCategory->sname}}<span class="opacity-50">(4)</span></label><br>
                                @else 
                                <input type="checkbox" {{in_array($subCategory->id,$splitSubcategories) ? 'checked':''}} name="subcategory"  class="form-check-input" data-id={{$subCategory->id}}>
                                <label class="form-check-label">{{$subCategory->sname}}<span class="opacity-50">(4)</span></label><br>
                                @endif
                                
                            @endforeach
                        </div>
                    @endif
                @endif
            </div>
            <div class="divProductBack mt-4 p-2">
                @if($brands->isNotEmpty())
                    <div class="divProductBack mt-4 p-2 position-relative">
                        <h6><b>Brands</b></h6>
                        <div class="form-check" onclick=brands(event)>
                            @if (!empty($splitBrands))
                                @foreach ($brands as $brand)
                                    <input type="checkbox" {{in_array($brand->id,$splitBrands) ? 'checked' : ''}} class="form-check-input" data-brand={{$brand->id}}>
                                    <label class="form-check-label">{{$brand->bname}}</label><br>
                                @endforeach 
                                
                                @else
                                
                                @foreach ($brands as $brand)
                                    <input type="checkbox" class="form-check-input" data-brand={{$brand->id}}>
                                    <label class="form-check-label">{{$brand->bname}}</label><br>
                                @endforeach 
                            @endif
                            
                        </div>
                    </div>
                @endif
            </div>
            <div class="divProductBack mt-4 p-2 position-relative">
                <h6><b>Price</b></h6>
                <div class="">
                    <input class="form-control mb-2" type="number" id="minPrice" placeholder="Min Value" min="{{$minPrice}}" max="{{$maxPrice}}" value="{{$minPrice}}" name="minValue"></input>
                    <input class="form-control" type="number" id="maxPrice" placeholder="Max Value" min="{{$minPrice}}" max="{{$maxPrice}}" value="{{$maxPrice}}" name="maxValue"></input>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('row 4')

@endsection
@section('row 5')

@endsection
@section('row 6')

@endsection 
@section("ActionSheet")
    <script type="text/javascript">
        let SubCategoriesId=[];
        let BrandsId=[];
        @if(isset($SubcategroyId))
            SubCategoriesId.push("{{ $SubcategroyId }}"); // Add the value to the array
        @endif
        @if(isset($splitSubcategories))
            @foreach ($splitSubcategories as $splitSubcategory)
                SubCategoriesId.push("{{ $splitSubcategory }}"); // Add the value to the array
            @endforeach
        @endif
        @if(isset($splitBrands))
            @foreach ($splitBrands as $splitBrand)
                BrandsId.push("{{ $splitBrand }}"); // Add the value to the array
            @endforeach
        @endif
      
        function sucategory(event){
            let category=event.target;
            if(SubCategoriesId.includes((category.dataset.id))){
                SubCategoriesId.splice(SubCategoriesId.indexOf(category.dataset.id),1)
            }
            else{
                SubCategoriesId.push(category.dataset.id);
            }
            console.log(SubCategoriesId);
        }
        function brands(event){
            let brandTag=event.target;
            if(BrandsId.includes((brandTag.dataset.brand))){
                BrandsId.splice(BrandsId.indexOf(brandTag.dataset.brand),1)
            }
            else{
                BrandsId.push(brandTag.dataset.brand);
            }
            console.log( BrandsId);
        }
        function ApplyFilters(event){
            url="{{url()->current()}}?";
            minPrice=document.getElementById("minPrice").value;
            maxPrice=document.getElementById("maxPrice").value;
            console.log(minPrice)
            console.log(maxPrice)

            if(SubCategoriesId.length>0){
                url+="&SubCategoriesId="+SubCategoriesId;
            }
            if(BrandsId.length>0){
                url+="&BrandsId="+BrandsId;
            }
            if(minPrice){
                url+="&minPrice="+minPrice;
            }
            if(maxPrice){
                url+="&maxPrice="+maxPrice;
            }
            if(event.target.id=="selectOptionId"){
                console.log(event.target.value)
                url+="&OrderBy="+event.target.value;
            }
            window.location.href=url;
        }
        
       
    </script>
   
@show
