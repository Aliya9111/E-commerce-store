@extends('AdminPages.layouts.AdminBase')
@section("CustomStyle")
@endsection
@section("title")
  <title>All pages</title>
@endsection 
@section('BreadCrumb')
    All Pages
@endsection
@section('MainPart')
    {{--  show the form of Add category etc. --}}
    <div class="row mt-3 ms-3 me-3 gy-2 justify-content-center">
        <div class="col-12 d-flex">
            <h3>All Pages:</h3>
            <a href="{{route('Pages.create')}}" class="btn btn-outline-dark ms-3 btn-sm mt-1 mb-1">Add new</a>
            <a href="{{route('Pages.index')}}" class="btn btn-outline-dark ms-3 btn-sm mt-1 mb-1">Clear</a>
        </div>
        
        
        {{--  display table  --}}
        <div class="col-12 mt-4" style="overflow-x: scroll;">
            {{--  search box and sorted list  --}}
            <div class="row">
                <div class="col-md-8 col-12 mt-2">
                    <form method="get" action="{{route('Pages.index')}}">
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
            @if (!empty($pages))
                
                <table class="table table-striped mt-2">
                    <thead align="center" style="white-space: nowrap;" >
                        <tr>
                            <th scope="col">Sr#no</th>
                            <th scope="col">Name</th>
                            <th scope="col">Slug</th>
                            <th scope="col">Status</th>
                            <th scope="col">Description</th>
                            <th scope="col">Created_at</th>
                            <th scope="col">Updated_at</th>
                            <th scope="col" colspan="2">Action</th>
                        </tr>
                    </thead>
                    <tbody align="center">
                        @foreach($pages as $page)
                            <tr  class="align-content-center">
                                <th>{{$page->id}}</th>
                                <td>{{$page->Name }}</td>
                                <td>{{$page->Slug}}</td>
                                <td>
                                    @if ($page->status=='1')
                                        Active
                                    @else 
                                        Deactive   
                                    @endif
                                </td>
                                <td>
                                    <a data-bs-toggle="modal" href="#staticBackdrop-{{$page->id}}Page">
                                      click here
                                    </a>
                                    
                                    {{--  <!-- Modal -->  --}}
                                    <div class="modal fade " id="staticBackdrop-{{$page->id}}Page" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel-{{$page->id}}Page" aria-hidden="true">
                                      <div class="modal-dialog">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="staticBackdropLabel-{{$page->id}}Page">Modal title</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                          </div>
                                          <div class="modal-body" >
                                            <p class="text-justify">{!! $page->Description !!}</p>
                                          </div>
                                          <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary">Understood</button>
                                          </div>
                                        </div>
                                      </div>
                                    </div></td>
                                <td>{{$page->created_at}}</td>
                                <td>{{$page->updated_at}}</td>

                                {{-- Delete--}}
                                <td>
                                    <form method="POST" action="{{route('Pages.destroy',$page->id)}}">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn d-inline"><i class="fa-solid fa-trash text-danger" onclick="window.alert('Do you want to delete this record');"></i></button>
                                        <a class="" href="{{route('Pages.edit',$page->id)}}"><i class="fa-solid fa-pen text-info"></i></a>
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
            {{ $pages->links('vendor.pagination.bootstrap-5') }}

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