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
  <title>All Coupan</title>
@endsection 
@section('BreadCrumb')
    All Coupans
@endsection
@section('MainPart')
    {{--  show the form of Add category etc. --}}
    <div class="row mt-3 ms-3 me-3 gy-2 justify-content-center">
        <div class="col-12 d-flex">
            <h3>All Coupans:</h3>
            <a href="{{route('Coupan.create')}}" class="btn btn-outline-dark ms-3 btn-sm mt-1 mb-1">Add new</a>
            <a href="{{route('Coupan.index')}}" class="btn btn-outline-dark ms-3 btn-sm mt-1 mb-1">Clear</a>
        </div>
        
        {{--  display table  --}}
        <div class="col-12 mt-4" style="overflow-x: scroll;">
            {{--  search box and sorted list  --}}
        <div class="row">
            <div class="col-md-8 col-12 mt-2">
                <form method="get" action="{{route('Coupan.index')}}">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="search" name="bkeyword" value="{{Request::get('bkeyword')}}" class="form-control" placeholder="search" aria-label="Username" aria-describedby="basic-addon1">
                        <span class="input-group-text" id="basic-addon1">
                            <button type="submit" class="border-0 bg-light"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </span>
                    
                    </div>
                </form>
            </div>
            <div class="col-md-4 col-12 mt-2">
                <select class="form-select" name="Coupansort" id="sortValue" onchange=ApplySort()>
                    <option value="asc" {{request('Coupansort')=='asc'? 'selected':''}}>Assecding</option>
                    <option value="desc" {{request('Coupansort')=='desc'? 'selected':''}}>Descssecding</option>
                    <option value="Latest" {{request('Coupansort')=='Latest'? 'selected':''}}>Latest</option>
                    <option value="Oldest" {{request('Coupansort')=='Oldest'? 'selected':''}}>Oldest</option>
                </select>
            </div>
            <div class="col-12 mt-2">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show p-3" role="alert">
                        <strong>Success! </strong>{{session('success')}}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>
        </div>
            <table class="table table-striped mt-2">
                <thead align="center" style="white-space: nowrap;">
                    <tr>
                        <th scope="col" class="borderb-Set">Sr#no</th>
                        <th scope="col" class="borderb-Set">Code</th>
                        <th scope="col" class="borderb-Set">name</th>
                        <th scope="col" class="borderb-Set">Description</th>
                        <th scope="col" class="borderb-Set">Max Uses</th>
                        <th scope="col" class="borderb-Set">Max Uses User</th>
                        <th scope="col" class="borderb-Set">Type</th>
                        <th scope="col" class="borderb-Set">Discount Amount</th>
                        <th scope="col" class="borderb-Set">Minimum Amount</th>
                        <th scope="col" class="borderb-Set">Status</th>
                        <th scope="col" class="borderb-Set">Starts at</th>
                        <th scope="col" class="borderb-Set">Expires at</th>
                        <th scope="col" class="borderb-Set">Created_at</th>
                        <th scope="col" class="borderb-Set">Updated_at</th>
                        <th scope="col" class="borderb-Set" colspan="2">Action</th>
                    </tr>
                </thead>
                <tbody align="center">
                    @if($coupans->isNotEmpty())
                        @foreach($coupans as $coupan)
                            <tr  class="align-content-center">
                                <th>{{$coupan->id}}</th>
                                <td>{{$coupan->code}}</td>
                                <td>{{$coupan->name }}</td>
                                <td>{{$coupan->description}}</td>
                                <td>{{$coupan->max_uses}}</td>
                                <td>{{$coupan->max_uses_user}}</td>
                                <td>{{$coupan->type}}</td>
                                <td>{{$coupan->discount_amount}}</td>
                                <td>{{$coupan->min_amount}}</td>
                                @if ($coupan->status=='0')
                                    <td>Deactive</td>
                                @else
                                    <td>Active</td>
                                @endif
                                <td>{{$coupan->satarts_at}}</td>
                                <td>{{$coupan->expires_at}}</td>
                                <td>{{$coupan->created_at}}</td>
                                <td>{{$coupan->updated_at}}</td>
                                {{-- Delete--}}
                                <td>
                                    <form method="POST" action="{{route('Coupan.destroy',$coupan->id)}}">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn d-inline" onclick="window.alert('Are you sure to delete this coupan')"><i class="fa-solid fa-trash text-danger"></i></button>
                                        <a class="" href="{{route('Coupan.edit',$coupan->id)}}"><i class="fa-solid fa-pen text-info"></i></a>
                                    </form>
                                    {{--  Update  --}}
                                </td>
                            </tr>

                        @endforeach

                    @else
                        <tr align="center">
                            <td colspan="9">No Coupan are availabe</td>
                        </tr>
                    @endif
                
                </tbody>
            </table>
        </div>
        <div class="col-12">
            {{ $coupans->links('vendor.pagination.bootstrap-5') }}

        </div>
        
    </div>
@endsection


@section('CustomAction')
<script>
    function ApplySort(){
        let url = "{{ url()->current() }}?";
        let getValue = document.getElementById("sortValue").value;
        window.location.href = url + 'Coupansort=' + getValue;
    }
</script>
@endsection