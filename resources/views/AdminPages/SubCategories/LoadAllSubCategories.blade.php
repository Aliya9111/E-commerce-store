@extends('AdminPages.layouts.AdminBase')
@section("CustomStyle")
<style>
    .borderb-Set{
        border-bottom: 2px solid black;
    }
</style>

@endsection
@section("title")
  <title>All SubCtaegories</title>
@endsection 
@section('BreadCrumb')
    All SubCategories
@endsection
@section('MainPart')
    {{--  show the form of Add category etc. --}}
    <div class="row mt-3 ms-3 me-3 gy-2 justify-content-center">
        <div class="col-12 d-flex">
            <h3>All SubCategories:</h3>
            <a href="{{route('SubCategories')}}" class="btn btn-outline-dark ms-3 btn-sm mt-1 mb-1">Add new</a>
            <a href="{{route('AllSubCategries')}}" class="btn btn-outline-dark ms-3 btn-sm mt-1 mb-1">Clear</a>
        </div>
        
        {{--  display table  --}}
        <div class="col-12 mt-4" style="overflow-x: scroll;">
            {{--  search box and sorted list  --}}
        <div class="row">
            <div class="col-md-8 col-12 mt-2">
                <form method="get" action="{{route('AllSubCategries')}}">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="search" name="skeyword" value="{{Request::get('skeyword')}}" class="form-control" placeholder="search" aria-label="Username" aria-describedby="basic-addon1">
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
                <tr>
                    <th scope="col" class="borderb-Set">Sr#no</th>
                    <th scope="col" class="borderb-Set">Image</th>
                    <th scope="col" class="borderb-Set">Name</th>
                    <th scope="col" class="borderb-Set">Slug</th>
                    <th scope="col" class="borderb-Set">Status</th>
                    <th scope="col" class="borderb-Set">Categories_id</th>
                    <th scope="col" class="borderb-Set">Show on Page</th>
                    <th scope="col" class="borderb-Set">Created_at</th>
                    <th scope="col" class="borderb-Set">Updated_at</th>
                    <th scope="col" class="borderb-Set" colspan="2">Action</th>
                </tr>
            </thead>
            @if($subcategories->isNotEmpty())
                <tbody align="center"> 
                    @foreach($subcategories as $subcategory)
                        <tr>
                            <td>{{ $subcategory->id }}</td>
                            <td>
                                {{--  set condition in componenet file if file are present so create this component  --}}
                                <x-AdminCom.imageShow :idSet="$subcategory->id" :Image="$subcategory->simage" :ImageAngle="$subcategory->SAngle"></x-AdminCom.imageShow>
                            </td>
                            <td>
                                <a data-bs-toggle="offcanvas" href="#offcanvasTop-{{$subcategory->id}}" aria-controls="offcanvasTop-{{$subcategory->id}}">
                                    {{ $subcategory->sname }}
                                </a>
                                {{--  show the category of subcategory along all subcategories of the parent(subcategory) of child(subcategories)  --}}
                                <x-AdminCom.Subcategories :subcategory="$subcategory"></x-AdminCom.Subcategories>
                            
                            </td>
                            <td>{{ $subcategory->sslug }}</td>
                            <td>{{ $subcategory->sstatus }}</td>
                            <td>{{ $subcategory->categories_id }}</td>
                            <td>{{ $subcategory->sShowPage }}</td>
                            <td>{{ $subcategory->created_at }}</td>
                            <td>{{ $subcategory->updated_at }}</td>
                            <td>
                                <a href="{{ route('SubCategoryUpdate', $subcategory->id) }}"><i class="fa-solid fa-pen text-info"></i></a>
                                <a href="{{ route('SubcategoryDelete', $subcategory->id) }}"><i class="fa-solid fa-trash text-danger" onclick="window.alert('Do you want to delete this record');"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            @else
                <tbody align="center">
                    <th colspan="12">No record avialbale </th>
                </tbody>
            @endif    
        </table>
        </div>
        <div class="col-12">
            {{ $subcategories->links('vendor.pagination.bootstrap-5') }}

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