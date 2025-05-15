@extends('AdminPages.layouts.AdminBase')
@section("CustomStyle")
{{--  <link href="{{ asset('Admin/css/BrandProduct.css') }}" rel="stylesheet">   --}}
<style>
    .borderb-Set{
        border-bottom: 2px solid black;
    }
    td{
        border-bottom: 0px;
    }
</style>
@endsection
@section("title")
  <title>All Orders</title>
@endsection 
@section('MainPart')
    {{--  show the form of Add category etc. --}}
    <div class="row mt-3 ms-3 me-3 gy-2 justify-content-center">
        <div class="col-12 d-flex">
            <h3>Orders:</h3>
            <a href="{{route('AllOrders')}}" class="btn btn-outline-dark ms-3 btn-sm mt-1 mb-1">Clear</a>
        </div>
        {{--  display table  --}}
        <div class="col-12 mt-4" style="overflow-x: scroll;">
            {{--  search box and sorted list  --}}
            <div class="row">
                <div class="col-md-8 col-12 mt-2">
                    <form method="get" action="{{route('AllOrders')}}">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="search" class="form-control" name="orderkeyword" value="{{Request::get('orderkeyword')}}" placeholder="search" aria-label="Username" aria-describedby="basic-addon1">
                            <span class="input-group-text" id="basic-addon1">
                                <button type="submit" class="border-0 bg-light"><i class="fa-solid fa-magnifying-glass"></i></button>
                            </span>
                        </div>
                    </form>
                </div>
                <div class="col-md-4 col-12 mt-2">
                    <select class="form-select" name="sort" id="sortValue" onchange=ApplySort()>
                        <option value="asc" {{request('sort')=='asc'? 'selected':''}}>Assecding</option>
                        <option value="desc" {{request('sort')=='desc'? 'selected':''}}>Descssecding</option>
                        <option value="Latest" {{request('sort')=='Latest'? 'selected':''}}>Latest</option>
                        <option value="Oldest" {{request('sort')=='Oldest'? 'selected':''}}>Oldest</option>
                    </select>
                </div>
                <div class="col-12 mt-2">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show p-3" role="alert">
                            <strong>!</strong> {{session('success')}}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                </div>
            </div>
            <table class="table table-striped mt-2 text-center">
                <thead>
                    <tr class="border-0">
                        <th scope="col" class="borderb-Set">Order No</th>
                        <th scope="col" class="borderb-Set">Total</th>
                        <th scope="col" class="borderb-Set">Order Date & timke</th>
                        <th scope="col" class="borderb-Set">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($orders->isNotEmpty())
                        @foreach ($orders as $order)
                            <tr class="border-0">
                                <td scope="row">
                                    <a href="{{route('LoadSingeOrder',['orderId'=>$order->id,'userId'=>$order->user_id])}}">{{$order->id}}</a>
                                </td>
                                <td>{{$order->grand_total}}</td>
                                <td>{{$order->created_at}}</td>

                                @if ($order->status=='pending')
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
        <div class="col-12">
            {{ $orders->links('vendor.pagination.bootstrap-5') }}
        </div>
        
    </div>
@endsection


@section('CustomAction')
    <script>
        function ApplySort(){
            let url = "{{ url()->current() }}?";
            let getValue = document.getElementById("sortValue").value;
            window.location.href = url + 'sort=' + getValue;
        }
    </script>
@endsection