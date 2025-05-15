@extends('AdminPages.layouts.AdminBase')
@section("CustomStyle")
<link href="{{ asset('Admin/css/dashboardstyle.css') }}" rel="stylesheet"> 
<style>
    .checkData:hover{
            cursor:pointer;
        }
        .th,td{
            border:0px
        }
</style>
    
@endsection
@section("title")
  <title>Dashboard</title>
@endsection 

@section('MainPart')
    {{--  show the orders, products, total orders etc. --}}
    <div class="row mt-3 ms-3 me-3 g-2 checkData" >
        <div class="col-lg-3 col-md-4 col-sm-6 col-12">
            <div class="d-flex align-items-center TotalProductsBack p-3 border rounded" onclick="window.location.href='{{route('productLoad')}}'">
                <div class="flex-shrink-0">
                    <i class="fa-brands fa-product-hunt DiconSize"></i>
                </div>
                <div class="flex-grow-1 ms-1 " >
                    <p class="mb-0 fw-bold text-center">Total Products</p>
                    <p class="mb-0 text-center">{{$products}}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 col-12" onclick="window.location.href='{{route('AllOrders')}}'">
            <div class="d-flex align-items-center TotalOrderssBack p-3 border rounded">
                <div class="flex-shrink-0">
                    <i class="fa-solid fa-cart-shopping DiconSize"></i>
                </div>
                <div class="flex-grow-1 ms-1">
                    <p class="mb-0 fw-bold text-center">Total Orders</p>
                    <p class="mb-0 text-center">{{$totaLOrders}}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 col-12" onclick="window.location.href='{{route('AllOrders')}}'">
            <div class="d-flex align-items-center NewOrsersBack p-3 border rounded">
                <div class="flex-shrink-0">
                    <i class="fa-solid fa-cart-shopping DiconSize"></i>
                </div>
                <div class="flex-grow-1 ms-1">
                    <p class="mb-0 fw-bold text-center">
                        New Orders
                        <a href="#"><span class="badge text-bg-danger ms-1">{{$NewOrders->count()}}</span></a>
                    </p>
                    <p class="mb-0 text-center">{{$newProducts}}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 col-12">
            <div class="d-flex align-items-center CommentssBack p-3 border rounded">
                <div class="flex-shrink-0">
                    <i class="fa-regular fa-comment DiconSize"></i>
                </div>
                <div class="flex-grow-1 ms-1">
                    <p class="mb-0 fw-bold text-center">
                        User Questions
                        <a href="#"><span class="badge text-bg-danger ms-1">{{$newUserQuestions}}</span></a>
                    </p>
                    <p class="mb-0 text-center">{{$UserQuestions}}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 col-12">
            <div class="d-flex align-items-center TotalSaleBack p-3 border rounded">
                <div class="flex-shrink-0">
                    <i class="fa-solid fa-chart-simple DiconSize"></i>
                </div>
                <div class="flex-grow-1 ms-1">
                    <p class="mb-0 fw-bold text-center">Total Sale</p>
                    <p class="mb-0 text-center">${{$TotalSale}}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 col-12">
            <div class="d-flex align-items-center TotalSaleBack p-3 border rounded">
                <div class="flex-shrink-0">
                    <i class="fa-solid fa-chart-simple DiconSize"></i>
                </div>
                <div class="flex-grow-1 ms-1">
                    <p class="mb-0 fw-bold text-center">This Month Sale</p>
                    <p class="mb-0 text-center">${{$thisMonthName}}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 col-12">
            <div class="d-flex align-items-center TotalSaleBack p-3 border rounded">
                <div class="flex-shrink-0">
                    <i class="fa-solid fa-chart-simple DiconSize"></i>
                </div>
                <div class="flex-grow-1 ms-1">
                    <p class="mb-0 fw-bold text-center">Last Month Sale ({{$LastMonthName}})</p>
                    <p class="mb-0 text-center">${{$lastMonthSale}}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 col-12">
            <div class="d-flex align-items-center TotalSaleBack p-3 border rounded">
                <div class="flex-shrink-0">
                    <i class="fa-solid fa-chart-simple DiconSize"></i>
                </div>
                <div class="flex-grow-1 ms-1">
                    <p class="mb-0 fw-bold text-center">Last 30 Days Sale</p>
                    <p class="mb-0 text-center">${{$lastThirtyDaysSale}}</p>
                </div>
            </div>
        </div>
        
    </div>

    {{--  show the new orders  --}}
    <div class="row mt-5 ms-3 me-3 justify-content-between">
        <div class="col-lg-7 col-12 overflow-scroll">
            <table class="table table-striped mt-2 text-center">
                <caption style="caption-side: top;font-size:25px;font-family:sans-serif;" class="fw-bold text-center">New Orders</caption>
                <thead>
                    <tr class="border-0">
                        <th scope="col">Order No</th>
                        <th scope="col">Total</th>
                        <th scope="col">Order Date & timke</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($NewOrders->isNotEmpty())
                        @foreach ($NewOrders as $NewOrder)
                            <tr class="border-0">
                                <td scope="row">
                                    <a href="{{route('LoadSingeOrder',['orderId'=>$NewOrder->id,'userId'=>$NewOrder->user_id])}}">{{$NewOrder->id}}</a>
                                </td>
                                <td>{{$NewOrder->grand_total}}</td>
                                <td>{{$NewOrder->created_at}}</td>

                                @if ($NewOrder->status=='pending')
                                    <td>
                                        <span class="text-danger p-1 rounded-2">pending</span>
                                    </td>
                                @elseif ($order->status=='shipped')
                                    <td>
                                        <span class="text-primary p-1 rounded-2">shipped</span>
                                    </td>
                                @else
                                    <td>
                                        <span class="text-success p-1 rounded-2">Delivered</span>
                                    </td>
                                @endif
                                {{--  <td>{{$order->status}}</td>  --}}
                            </tr>
                        @endforeach
                    @else
                        <tr class="text-center" ><td colspan="4">Empty</td></tr>
                    @endif
                        
                </tbody>
            </table>
        </div>
        <div class="col-lg-4 col-12">
            <div class="bg-light shadow-sm overflow-x-scroll p-3">
                <h6 style="opacity: 0.9;font-family:sans-serif; font-weight: bold;;">Recent Buyers</h6>
                @if (!empty($recentBuyers))
                    @foreach ($recentBuyers as $recentBuyer)
                        <div class="d-flex">
                            @php
                                $user=$recentBuyer->user;
                            @endphp
                            <div class="flex-shrink-0" style="max-height: 50px;max-width:50px;">
                                @if (!empty($user->image))
                                    <img src="{{asset($user->image)}}" style="height: 100%;width:100%;" class="img-fluid object-fit-cover rounded-circle">
                                @else
                                    <img src="{{asset('/images/profile.jfif')}}" style="height: 100%;width:100%;" class="img-fluid object-fit-cover rounded-circle">
                                @endif
                            </div>
                            <div class="flex-grow-1 p-2" style="font-size: 12px;font-family:sans-serif;opacity:0.9;font-weight:bold;">
                                <p class="mb-0">{{$user->name}}</p>
                                @php
                                    $productIds=$recentBuyer->order_items()->select('products_id')->get();
                                    $categories=App\Helper\Helper::Buyercategories($productIds);
                                @endphp
                                <ul class="list-unstyled d-flex gap-2">
                                    @foreach ($categories as $category)
                                        <li class="TotalOrderssBack rounded-2 ps-1 pe-1">{{$category}}</li>
                                    @endforeach
                                    <li>${{$recentBuyer->grand_total}}</li>
                                </ul>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            
        </div>
    </div>
@endsection

@section('CustomAction')
    <script src="{{ asset('Admin/js/dashboardAction.js') }}"></script>
    <script src="{{ asset('chartjs/chart.umd.js') }}"></script>
    <script src="{{ asset('Admin/js/chartData.js') }}"></script>
@show