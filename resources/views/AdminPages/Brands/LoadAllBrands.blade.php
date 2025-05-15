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
  <title>All Brands</title>
@endsection 
@section('BreadCrumb')
    All Brands
@endsection
@section('MainPart')
    {{--  show the form of Add category etc. --}}
    <div class="row mt-3 ms-3 me-3 gy-2 justify-content-center">
        <div class="col-12 d-flex">
            <h3>All Brands:</h3>
            <a href="{{route('Brand')}}" class="btn btn-outline-dark ms-3 btn-sm mt-1 mb-1">Add new</a>
            <a href="{{route('AllBrands')}}" class="btn btn-outline-dark ms-3 btn-sm mt-1 mb-1">Clear</a>
        </div>
        
        {{--  display table  --}}
        <div class="col-12 mt-4" style="overflow-x: scroll;">
            {{--  search box and sorted list  --}}
        <div class="row">
            <div class="col-md-8 col-12 mt-2">
                <form method="get" action="">
                    @csrf
                    <form method="get" action="{{route('AllBrands')}}">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="search" name="bkeyword" value="{{Request::get('bkeyword')}}" class="form-control" placeholder="search" aria-label="Username" aria-describedby="basic-addon1">
                            <span class="input-group-text" id="basic-addon1">
                                <button type="submit" class="border-0 bg-light"><i class="fa-solid fa-magnifying-glass"></i></button>
                            </span>
                        
                        </div>
                    </form>
                </form>
            </div>
            <div class="col-md-4 col-12 mt-2">
                <select class="form-select" name="bsort" id="sortValue" onchange=ApplySort()>
                    <option value="asc" {{request('bsort')=='asc'? 'selected':''}}>Assecding</option>
                    <option value="desc" {{request('bsort')=='desc'? 'selected':''}}>Descssecding</option>
                    <option value="Latest" {{request('bsort')=='Latest'? 'selected':''}}>Latest</option>
                    <option value="Oldest" {{request('bsort')=='Oldest'? 'selected':''}}>Oldest</option>
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
                    <tr>
                        <th scope="col" class="borderb-Set">Sr#no</th>
                        <th scope="col" class="borderb-Set">Name</th>
                        <th scope="col" class="borderb-Set">Slug</th>
                        <th scope="col" class="borderb-Set">Status</th>
                        <th scope="col" class="borderb-Set">Show on Page</th>
                        <th scope="col" class="borderb-Set">Created_at</th>
                        <th scope="col" class="borderb-Set">Updated_at</th>
                        <th scope="col" class="borderb-Set" colspan="2">Action</th>
                    </tr>
                </thead>
                <tbody align="center">
                    @if($brands->isNotEmpty())
                        @foreach($brands as $brand)
                            <tr  class="align-content-center">
                                <th>{{$brand->id}}</th>
                                <td>{{ $brand->bname }}</td>
                                <td>{{$brand->bslug}}</td>
                                <td>{{$brand->bstatus}}</td>
                                <td>{{$brand->bShowPage}}</td>
                                <td>{{$brand->created_at}}</td>
                                <td>{{$brand->updated_at}}</td>

                                {{-- Delete--}}
                                <td>
                                    <form method="POST" action="{{route('brandDelete',$brand->id)}}">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn d-inline"><i class="fa-solid fa-trash text-danger" onclick="window.alert('Do you want to delete this record');"></i></button>
                                        <a class="" href="{{route('BrandUpdateLoad',$brand->id)}}"><i class="fa-solid fa-pen text-info" ></i></a>
                                    </form>
                                    {{--  Update  --}}
                                </td>
                            </tr>

                        @endforeach

                    @else
                        <tr align="center">
                            <td colspan="9">No Brand are availabe</td>
                        </tr>
                    @endif
                
                </tbody>
            </table>
        </div>
        <div class="col-12">
            {{ $brands->links('vendor.pagination.bootstrap-5') }}

        </div>
        
    </div>
@endsection


@section('CustomAction')
<script>
    function ApplySort(){
        let url = "{{ url()->current() }}?";
        let getValue = document.getElementById("sortValue").value;
        window.location.href = url + 'bsort=' + getValue;
    }
</script>
@endsection