<div class="d-sm-none d-block">
    <button class="btn btn-ligh bg-info border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling" aria-controls="offcanvasScrolling">
        <i class="fa-solid fa-bars"></i>
    </button>
    
    <div class="offcanvas offcanvas-start" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="offcanvasScrolling" aria-labelledby="offcanvasScrollingLabel">
      <div class="offcanvas-header p-2 bg-info">
        <h5 class="offcanvas-title" id="offcanvasScrollingLabel">Online store</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body mt-0">
        <div class="row">
            
            {{--  show all tabs  --}}
            <div class="col-12 bg-info  border-top border-2" style="height: 100vh;">
                    {{--  dashboard  --}}
                <div class="row mt-3 p-1">
                    <div class="col-2  align-content-center">
                        <i class="fa-solid fa-gauge text-dark fs-4"></i>
                    </div>
                    <div class="col-8 align-content-center hidea d-inline">
                        <a class="nav-link text-dark d-inline" href="{{route('dashborad')}}">Dashboard</a>
    
                    </div>
                </div>

                {{--  category  --}}
                <div class="row mt-2 cate p-1" >
                    <div class="col-2 align-content-center c1 hidea d-inline">
                        <i class="fa-solid fa-list fs-4"></i>
                       
                    </div>
                    {{--  click on tag and open below list  --}}
                    <div class="col-10  align-content-center hidea d-inline c2">
                        <a class="nav-link text-dark d-inline" onclick=ChangeColorClick(event) data-bs-toggle="collapse" href="#collapseExample1" role="button" aria-expanded="false" aria-controls="collapseExample">
                            Category
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
                <div class="row mt-2 Subcate p-1">
                    <div class="col-2  align-content-center sc1 hidea d-inline">
                        <i class="fa-solid fa-layer-group fs-4"></i>
                    </div>
                    <div class="col-10  align-content-center hidea d-inline sc2">
                        <a class="nav-link text-dark d-inline" onclick=ChangeColorClick(event) data-bs-toggle="collapse" href="#collapseExample2" role="button" aria-expanded="false" aria-controls="collapseExample">
                            SubCategory
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
                <div class="row mt-2 brand p-1">
                    <div class="col-2 align-content-center b1 hidea d-inline">
                        <i class="fa-solid fa-copyright fs-4"></i>
                    </div>
                    <div class="col-10 align-content-center hidea d-inline b2">
                        <a class="nav-link text-dark d-inline" onclick=ChangeColorClick(event) data-bs-toggle="collapse" href="#collapseExample3" role="button" aria-expanded="false" aria-controls="collapseExample">
                            Brands
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
                <div class="row mt-2 pro p-1">
                    <div class="col-2 align-content-center p1 hidea d-inline">
                        <i class="fa-brands fa-product-hunt fs-4"></i>
                    </div>
                    <div class="col-10 align-content-center hidea d-inline p2">
                        <a class="nav-link text-dark d-inline" onclick=ChangeColorClick(event) data-bs-toggle="collapse" href="#collapseExample4" role="button" aria-expanded="false" aria-controls="collapseExample">
                            Products
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
                <div class="row mt-2 p-1">
                    <div class="col-2  align-content-center">
                        <i class="fa-solid fa-truck-fast fs-4"></i>
                    </div>
                    <div class="col-8  align-content-center hidea d-inline">
                        <a class="nav-link text-dark d-inline" href=""> Shipping</a>
                    </div>
                </div>
                {{--  orders  --}}
                <div class="row mt-2 p-1">
                    <div class="col-2  align-content-center">
                        <i class="fa-brands fa-first-order fs-4"></i>
                    </div>
                    <div class="col-8  align-content-center hidea d-inline">
                        <a class="nav-link text-dark d-inline" href="#">Orders</a>
                    </div>
                </div>
                {{--  discount  --}}
                <div class="row mt-2 p-1">
                    <div class="col-2  align-content-center">
                        <i class="fa-solid fa-tag fs-4"></i>
                    </div>
                    <div class="col-8  align-content-center hidea d-inline">
                        <a class="nav-link text-dark d-inline" href="#">Discount</a>
                    </div>
                </div>
                {{--  users  --}}
                <div class="row mt-2 usr p-1" >
                    <div class="col-2 align-content-center u1 hidea d-inline">
                        <i class="fa-solid fa-user fs-4"></i>
                    </div>
                    <div class="col-10 align-content-center hidea d-inline u2">
                        <a class="nav-link text-dark d-inline" onclick=ChangeColorClick(event) data-bs-toggle="collapse" href="#collapseExample5" role="button" aria-expanded="false" aria-controls="collapseExample">
                            Users
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
                <div class="row mt-2 p-1">
                    <div class="col-2  align-content-center">
                        <i class="fa-solid fa-file fs-4"></i>
                    </div>
                    <div class="col-8  align-content-center hidea d-inline">
                        <a class="nav-link text-dark d-inline" href="#">Pages</a>
                    </div>
                </div>
                {{--  statistics  --}}
                <div class="row mt-2 p-1">
                    <div class="col-2  align-content-center">
                        <i class="fa-solid fa-chart-simple"></i>
                    </div>
                    <div class="col-8  align-content-center hidea d-inline">
                        <a class="nav-link text-dark d-inline" href="#">Statistics</a>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
</div>
