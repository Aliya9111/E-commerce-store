@extends('AdminPages.layouts.AdminBase')
@section("CustomStyle")
<link href="{{ asset('Admin/css/DisUser.css') }}" rel="stylesheet"> 
<style>
    .borderb-Set{
        border-bottom: 2px solid black;
    }
</style>
@endsection
@section("title")
  <title>All Users</title>
@endsection 
@section('BreadCrumb')
    All Users
@endsection
@section('MainPart')
    {{--  show the form of Add category etc. --}}
    <div class="row mt-3 ms-3 me-3 gy-2 justify-content-center">
        <div class="col-12 d-flex">
            <h3>All Users:</h3>
            <a href="{{route('user')}}" class="btn btn-outline-dark ms-3 btn-sm mt-1 mb-1">Add new</a>
            <a href="{{route('Allusers')}}" class="btn btn-outline-dark ms-3 btn-sm mt-1 mb-1">clear</a>
        </div>
        
        {{--  display table  --}}
        <div class="col-12 mt-4" style="overflow-x: scroll;">
            {{--  search box and sorted list  --}}
        <div class="row">
            <div class="col-md-8 col-12 mt-2">
                <form method="get" action="{{route('Allusers')}}">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="search" name="ukeyword" value="{{Request::get('ukeyword')}}" class="form-control" placeholder="search" aria-label="Username" aria-describedby="basic-addon1">
                        <span class="input-group-text" id="basic-addon1">
                            <button type="submit" class="border-0 bg-light"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </span>
                    
                    </div>
                </form>
            </div>
            <div class="col-md-4 col-12 mt-2">
                <select class="form-select" name="usort" id="sortValue" onchange=ApplySort()>
                    <option value="asc" {{request('usort')=='asc'? 'selected':''}}>Assecding</option>
                        <option value="desc" {{request('usort')=='desc'? 'selected':''}}>Descssecding</option>
                        <option value="Latest" {{request('usort')=='Latest'? 'selected':''}}>Latest</option>
                        <option value="Oldest" {{request('usort')=='Oldest'? 'selected':''}}>Oldest</option>
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
        @if (!empty($users))
            <table class="table table-striped mt-2">
                <thead align="center" style="white-space: nowrap;" >
                    <tr>
                        <th scope="col" class="borderb-Set">Sr#no</th>
                        <th scope="col" class="borderb-Set">Image</th>
                        <th scope="col" class="borderb-Set">Name</th>
                        <th scope="col" class="borderb-Set">Email</th>
                        <th scope="col" class="borderb-Set">password</th>
                        <th scope="col" class="borderb-Set">Status</th>
                        <th scope="col" class="borderb-Set">Block User</th>
                        <th scope="col" class="borderb-Set">Created_at</th>
                        <th scope="col" class="borderb-Set">Updated_at</th>
                        <th scope="col" class="borderb-Set" colspan="2">Action</th>
                    </tr>
                </thead>
                <tbody align="center">
                    @if($users->isNotEmpty())
                        @foreach($users as $user)
                            <tr  class="align-content-center">
                                <th>{{$user->id}}</th>
                                <td>
                                    {{--  set condition in componenet file if file are present so create this component  --}}
                                    <x-AdminCom.imageShow :idSet="$user->id" :Image="$user->image" :ImageAngle="$user->angle"></x-AdminCom.imageShow>
                                </td>
                                <td>{{$user->name }}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->password}}</td>
                                <td>{{$user->status}}</td>
                                <td>{{$user->UserBlock}}</td>
                                <td>{{$user->created_at}}</td>
                                <td>{{$user->updated_at}}</td>

                                {{-- Delete $ update--}}
                                <td>
                                    <form method="POST" action="{{route('userdelete',$user->id)}}">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn d-inline"><i class="fa-solid fa-trash text-danger" onclick="window.alert('Do you want to delete this record');"></i></button>
                                        <a class="" href="{{route('UpdateLoaduser',$user->id)}}"><i class="fa-solid fa-pen text-info"></i></a>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @else
                            <tr align="center">
                                <td colspan="11">No user found</td>
                            </tr>
                    @endif        
                </tbody>
            </table>
        @endif
        </div>
        <div class="col-12">
            {{ $users->links('vendor.pagination.bootstrap-5') }}

        </div>
    </div>
@endsection


@section('CustomAction')
    <script>
        function ApplySort(){
            let url = "{{ url()->current() }}?";
            console.log(url);
            let getValue = document.getElementById("sortValue").value;
            window.location.href = url + 'usort=' + getValue;
        }
    </script>
    <script src="{{ asset('Admin/js/DisUser.js') }}"></script>
@endsection