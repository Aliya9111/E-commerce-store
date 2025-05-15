@props(['subcategory'])
<div class="offcanvas offcanvas-top h-100" tabindex="-1" id="offcanvasTop-{{$subcategory->id}}" aria-labelledby="offcanvasTopLabel-{{$subcategory->id}}">
  <div class="offcanvas-header">
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <table class="table table table-success table-striped">
        <thead>
            <tr align="center">
                <th colspan="10" class="fs-3">Category</th>
            </tr>
            <tr>
                <th scope="col">Sr#no</th>
                <th scope="col">Image</th>
                <th scope="col">Name</th>
                <th scope="col">Slug</th>
                <th scope="col">Status</th>
                <th scope="col">Show on Page</th>
                <th scope="col">Created_at</th>
                <th scope="col">Updated_at</th>
                <th scope="col" colspan="2">Action</th>
            </tr>
        </thead>
        @php
            $category= $subcategory->categories()->first();
            $subcategories=$category->Subcategories()->get();
        @endphp
        <tbody>
            <tr>
                <th>{{$category->id}}</th>
                <td>
                    <x-AdminCom.imageShow :category="$category"></x-AdminCom.imageShow>
                </td>
                <td>{{$category->cname}}</td>
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
                        <button type="submit" class="btn d-inline"><i class="fa-solid fa-trash text-danger"></i></button>
                        <a class="" href="{{route('CategoryUpdateLoad',$category->id)}}"><i class="fa-solid fa-pen text-info"></i></a>
                    </form> 
                </td>   
            </tr>
        </tbody> 
    </table>
    <table class="table table table-success table-striped">
        <thead>
            <tr align="center">
                <th colspan="10" class="fs-3">Sub Categories</th>
            </tr>
            <tr>
                <th scope="col">Sr#no</th>
                <th scope="col">Image</th>
                <th scope="col">Name</th>
                <th scope="col">Slug</th>
                <th scope="col">Status</th>
                <th scope="col">Show on Page</th>
                <th scope="col">Created_at</th>
                <th scope="col">Updated_at</th>
                <th scope="col" colspan="2">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($subcategories as $subcategory)
                <tr>
                    <th>{{$subcategory->id}}</th>
                    <td>
                        @if(!empty($subcategory->simage))
                            <img src="{{asset($subcategory->simage)}}" width="50">
                        
                        @endif
                    </td>
                    <td>{{$subcategory->sname}}</td>
                    <td>{{$subcategory->sslug}}</td>
                    <td>{{$subcategory->sstatus}}</td>
                    <td>{{$subcategory->sShowPage}}</td>
                    <td>{{$subcategory->created_at}}</td>
                    <td>{{$subcategory->updated_at}}</td>

                    {{-- Delete $ update--}}
                    <td>
                        <a href="{{ route('SubCategoryUpdate', $subcategory->id) }}"><i class="fa-solid fa-pen text-info"></i></a>
                        <a href="{{ route('SubcategoryDelete', $subcategory->id) }}"><i class="fa-solid fa-trash text-danger"></i></a>
                    </td>
                </tr>
            @endforeach    
        </tbody> 
    </table>
  </div>
</div>