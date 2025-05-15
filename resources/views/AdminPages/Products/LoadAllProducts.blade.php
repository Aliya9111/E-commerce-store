@extends('AdminPages.layouts.AdminBase')
@section("CustomStyle")
{{--  <link href="{{ asset('Admin/css/BrandProduct.css') }}" rel="stylesheet">   --}}
<style>
    .borderb-Set{
        border-bottom: 2px solid black;
    }
</style>
@endsection
@section("title")
  <title>All Products</title>
@endsection 
@section('BreadCrumb')
    All Products
@endsection
@section('MainPart')
    {{--  show the form of Add category etc. --}}
    <div class="row mt-3 ms-3 me-3 gy-2 justify-content-center">
        <div class="col-12 d-flex">
            <h3>All Products:</h3>
            <a href="{{route('product')}}" class="btn btn-outline-dark ms-3 btn-sm mt-1 mb-1">Add new</a>
            <a href="{{route('productLoad')}}" class="btn btn-outline-dark ms-3 btn-sm mt-1 mb-1">Clear</a>
        </div>
        
        {{--  display table  --}}
        <div class="col-12 mt-4" style="overflow-x: scroll;">
            {{--  search box and sorted list  --}}
        <div class="row">
            <div class="col-md-8 col-12 mt-2">
                <form method="get" action="{{route('productLoad')}}">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="search" class="form-control" name="productkeyword" value="{{Request::get('productkeyword')}}" placeholder="search" aria-label="Username" aria-describedby="basic-addon1">
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
            <table class="table table-striped mt-2">
                <thead align="center" style="white-space: nowrap;">
                    <tr class="p-0">
                        <th scope="col" class="borderb-Set">Sr#no</th>
                        <th scope="col" class="borderb-Set">Image</th>
                        <th scope="col" class="borderb-Set">Title</th>
                        <th scope="col" class="borderb-Set">Slug</th>
                        <th scope="col" class="borderb-Set">Status</th>
                        <th scope="col" class="borderb-Set">Featured Products</th>
                        <th scope="col" class="borderb-Set">Related products</th>
                        <th scope="col" class="borderb-Set">Short Description</th>
                        <th scope="col" class="borderb-Set">Description</th>
                        <th scope="col" class="borderb-Set">Shipping&Return</th>
                        <th scope="col" class="borderb-Set">Price</th>
                        <th scope="col" class="borderb-Set">Compare_Price</th>
                        <th scope="col" class="borderb-Set">SKU</th>
                        <th scope="col" class="borderb-Set">Barcode</th>
                        <th scope="col" class="borderb-Set">track quantity</th>
                        <th scope="col" class="borderb-Set">Quantity</th>
                        <th scope="col" class="borderb-Set">Category id</th>
                        <th scope="col" class="borderb-Set">SubCategory id</th>
                        <th scope="col" class="borderb-Set">Brand id</th>
                        <th scope="col" class="borderb-Set">Created_at</th>
                        <th scope="col" class="borderb-Set">Updated_at</th>
                        <th scope="col" class="borderb-Set" colspan="2">Action</th>
                    </tr>
                </thead>
                <tbody align="center">
                    @if ($products->isNotEmpty())
                        @foreach($products as $product)
                            <tr class="p-0">
                                <th scope="row">{{$product->id}}</th>
                                @php
                                $productImage=$product->productImages()->first();
                                $AllImages=$product->productImages()->get();
                                @endphp
                                <td>
                                    @if (!empty($productImage))
                                        <x-AdminCom.prodctImages :pid="$product->id" :productImage="$productImage" :AllImages="$AllImages">

                                        </x-AdminCom.prodctImages>
                                    @endif
                                </td>
                                <td>{{$product->title}}</td>
                                <td>{{$product->slug}}</td>
                                <td>{{$product->pstatus}}</td>
                                <td>{{$product->ProductFeature}}</td>
                                <td>{{$product->relatedProducts}}</td>
                                <td>{{$product->ShortDescription}}</td>
                                <td>{{$product->Description}}</td>
                                <td>{{$product->Shipping_returns}}</td>
                                <td>{{$product->price}}</td>
                                <td>{{$product->compare_price}}</td>
                                <td>{{$product->sku}}</td>
                                <td>{{$product->barcode}}</td>
                                <td>{{$product->track_qty}}</td>
                                <td>{{$product->quantity}}</td>
                                <td>{{$product->categories_id}}</td>
                                <td>{{$product->Subcategories_id}}</td>
                                <td>{{$product->brands_id}}</td>
                                <td>{{$product->created_at}}</td>
                                <td>{{$product->updated_at}}</td>

                                {{--Update and Delete the brand  --}}
                                <td>
                                    <form method="POST" action="{{ route('productDelete', $product->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-info border-0 bg-light"><i class="fa-solid fa-trash text-danger" onclick="window.alert('Do you want to delete this record');"></i></button>
                                        <a href="{{ route('ProductUpdateLoad', $product->id) }}"><i class="fa-solid fa-pen text-info"></i></a>
                                    
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    
                    @else
                        <tr align="center">
                            <td colspan="22">Not found</td>
                        </tr>
                    @endif
                    
                </tbody>
            </table>
        </div>
        <div class="col-12">
            {{ $products->links('vendor.pagination.bootstrap-5') }}

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
    <script src="{{ asset('Admin/js/BrandProduct.js') }}"></script>
@endsection