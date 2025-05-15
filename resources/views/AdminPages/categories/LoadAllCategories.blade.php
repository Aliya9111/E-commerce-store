@extends('AdminPages.layouts.AdminBase')
@section("CustomStyle")
<style>
    .borderb-Set{
        border-bottom: 2px solid black;
    }
</style>
@endsection
@section("title")
  <title>All Ctaegories</title>
@endsection 
@section('BreadCrumb')
    All Categories
@endsection
@section('MainPart')
    {{--  show the form of Add category etc. --}}
    <div class="row mt-3 ms-3 me-3 gy-2 justify-content-center">
        <div class="col-12 d-flex">
            <h3>All Categories:</h3>
            <a href="{{route('Categories')}}" class="btn btn-outline-dark ms-3 btn-sm mt-1 mb-1">Add new</a>
            <a href="{{route('AllCategries')}}" class="btn btn-outline-dark ms-3 btn-sm mt-1 mb-1">Clear</a>
        </div>
        
        
        {{--  display table  --}}
        <div class="col-12 mt-4" style="overflow-x: scroll;">
            {{--  search box and sorted list  --}}
            <div class="row">
                <div class="col-md-8 col-12 mt-2">
                    <form method="get" action="{{route('AllCategries')}}">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="search" name="keyword" value="{{Request::get('keyword')}}" class="form-control" placeholder="search" aria-label="Username" aria-describedby="basic-addon1">
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
            @if (!empty($categories))
                
                <table class="table table-striped mt-2">
                    <thead align="center" style="white-space: nowrap;" >
                        <tr>
                            <th scope="col" class="borderb-Set">Sr#no</th>
                            <th scope="col" class="borderb-Set">Image</th>
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
                        @foreach($categories as $category)
                            <tr  class="align-content-center">
                                <th>{{$category->id}}</th>
                                <td>
                                {{--  set condition in componenet file if file are present so create this component  --}}
                                    <x-AdminCom.imageShow :idSet="$category->id" :Image="$category->cimage" :ImageAngle="$category->CAngle"></x-AdminCom.imageShow>
                                </td>
                                <td>
                                    <a data-bs-toggle="offcanvas" href="#offcanvasTop-{{$category->id}}" aria-controls="offcanvasTop-{{$category->id}}">
                                        {{ $category->cname }}
                                    </a>
                                    {{-- all subcategories of the all categories  --}}
                                    <x-AdminCom.categories :category="$category"></x-AdminCom.categories>
                                </td>
                               
                                <td>{{$category->cslug}}</td>
                                <td>{{$category->cstatus}}</td>
                                <td>{{$category->cShowPage}}</td>
                                <td>{{$category->created_at}}</td>
                                <td>{{$category->updated_at}}</td>

                                {{-- Delete--}}
                                <td>
                                    <form method="POST" action="{{route('CategoryDelete',$category->id)}}">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn d-inline"><i class="fa-solid fa-trash text-danger" onclick="window.alert('Do you want to delete this record');"></i></button>
                                        <a class="" href="{{route('CategoryUpdateLoad',$category->id)}}"><i class="fa-solid fa-pen text-info"></i></a>
                                    </form>
                                    {{--  Update  --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
        
        <div class="col-12">
            {{ $categories->links('vendor.pagination.bootstrap-5') }}

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

        {{--  delete the record after get permission  --}}
        
    </script>
@endsection