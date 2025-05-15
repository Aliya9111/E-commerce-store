@props(['category'])
<div class="offcanvas offcanvas-top h-100" tabindex="-1" id="offcanvasTop-{{$category->id}}" aria-labelledby="offcanvasTopLabel-{{$category->id}}">
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
            $subcategories=$category->Subcategories()->get();
        @endphp

        <tbody>
            @if($subcategories->isNotEmpty())
                @foreach($subcategories as $subcategory)
                <tr>
                    <th>{{$subcategory->id}}</th>
                    <td>
                        <x-AdminCom.imageShow :idSet="$subcategory->id" :Image="$subcategory->simage"></x-AdminCom.imageShow>
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
            @else
            <tr align="center">
                <td colspan="10">No Subcategory found of {{$category->cname}}</td>
            </tr>
            @endif
            
        </tbody> 
    </table>
  </div>
</div>