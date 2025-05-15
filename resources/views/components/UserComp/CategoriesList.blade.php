@php
    $Categories=App\Helper\Helper::categories();
@endphp
@if (!empty($Categories))
    <div class="position-relative me-3 d-lg-inline d-none align-content-center" id="list-id" style="width: 200px;">
        <div class="d-flex CateBack p-2 w-100 border-top rounded-3 border-light border-2 showList">
            <div class="me-2 ms-2 text-light"><i class="fa-solid fa-bars" style="font-size:20px;"></i></div>
            <div class="text-light">All Categories</div>
            {{--  set the onclick event ShowList()  --}}
            @if (!empty($Categories))
                <div class="ms-auto me-2 text-light"><i class="fa-solid fa-angle-right mt-1 "></i></div>
            @endif
        </div>
        <div class="position-absolute listHideShow targetlist" style="z-index: 100">
            {{--  category list  --}}
            <ol class="list-unstyled list-group bg-light">
                @foreach ($Categories as $Category)
                    <li class="d-flex pb-2" style="height:30px;">
                            <a href="{{route('ProductsLoad',['categoriId'=>$Category->id])}}" class="nav-link link-dark" style="width: 90%">
                                {{$Category->cname}}<p class="opacity-50 d-inline"> ({{App\Helper\Helper::productsQuantity('categories_id',$Category->id)}})</p>
                            </a> 
                            @php
                                $subCategories=$Category->subcategories()->orderBy('sname','asc')->get();
                            @endphp
                            @if ($subCategories->isNotEmpty())
                                <div class="ms-auto setAngle mt-2 me-1" id="rotateDiv" onclick=AngleChange(event) style="transform: rotate(360deg)">
                                    <i class="fa-solid fa-angle-right showList" data-bs-toggle="collapse" data-bs-target="#collapseExample-{{$Category->id}}" ></i>
                                </div>
                            @endif
                    </li>
                        @if (!empty($subCategories))
                            @foreach ($subCategories as $subCategory)
                                <div class="collapse" id="collapseExample-{{$Category->id}}">
                                    <div class="card card-body border-0 bg-light p-0">
                                        <ol class="mt-0 ms-0" style="font-size: 15px;list-style-type:circle">
                                            <li class="pb-2" style="height:30px;">
                                                <a class="nav-link link-dark" href="{{route('ProductsLoad',['categoriId'=>$Category->id,'Subcategroy'=>$subCategory->id])}}">{{$subCategory->sname}}
                                                    <p class="opacity-50 d-inline"><p class="opacity-50 d-inline"> ({{App\Helper\Helper::productsQuantity('Subcategories_id',$subCategory->id)}})</p>
                                                </a>
                                            </li>
                                        </ol>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                @endforeach
            </ol>
        </div>
    </div>
    @else
    <div class="me-3 d-lg-inline d-none text-center align-content-center bg-dark text-light border-top border-2 rounded-3" id="list-id" style="width: 200px;">
        Empty Categories
    </div>
@endif




