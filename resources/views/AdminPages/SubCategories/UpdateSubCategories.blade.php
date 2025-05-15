@extends('AdminPages.layouts.AdminBase')
@section("CustomStyle")
<link href="{{ asset('Admin/css/categorySub.css') }}" rel="stylesheet"> 
@endsection
@section("title")
  <title>EditSubCategories</title>
@endsection 
@section('BreadCrumb')
    Edit SubCategories
@endsection
@section('MainPart')
    {{--  show the form of Add subcategory etc. --}}
    <div class="row mt-3 ms-3 me-3 gy-2 justify-content-around">
        <div class="row">
            <div class="col-12 d-flex">
                <h3>Edit SubCategory:</h3>
                <a href="{{route('SubCategoryUpdate',$subcategory->id)}}" class="btn btn-outline-dark ms-3 btn-sm mt-1 mb-1">Clear data</a>
                <a href="{{route('AllSubCategries')}}" class="btn btn-outline-dark ms-3 btn-sm mt-1 mb-1">Check all</a>
            </div>
            <div class="col-12 mt-2">
                @if (session('success'))
                    
                <div class="alert alert-success alert-dismissible fade show p-3" role="alert">
                    <strong>!</strong> {{session('success')}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
                    
                @endif
                @if (session('fail'))
                    
                <div class="alert alert-danger alert-dismissible fade show p-3" role="alert">
                    <strong>!</strong> {{session('fail')}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
                    
                @endif
            </div>
        </div>
        {{--  first part of row  --}}
        <div class="col-md-7 col-12 g-2">
            <div class="row">
                <div class="col-12 bg-light shadow-sm">
                    <form method="POST" action="{{route('SubCatUpdate',$subcategory->id)}}" enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                        {{--  name of the Subcategory  --}}
                        <label class="form-label mt-3"><b>Name:</b></label>
                        <input type="text" name="sname" value={{old('sname',$subcategory->sname)}} class="form-control">
                        @error('sname')
                        <p class="text-danger">{{$message}}</p>
                        @enderror
                        {{--  slug of the Subcategory  --}}
                        <label class="form-label mt-3"><b>Slug:</b></label>
                        <input type="text" name="sslug" value={{old('sslug',$subcategory->sslug)}} class="form-control mb-3">
                        @error('sslug')
                        <p class="text-danger">{{$message}}</p>
                        @enderror
                </div>
                {{--image part   --}}
                <div class="col-12 bg-light shadow-sm mt-3">
                    <label class="form-label mt-2"><b>Image:</b></label>
                    <input type="hidden" name="rotation-angel1" value="{{$subcategory->SAngle}}" id="angel-set1">
                    <input type="file" id="emptyValue" class="form-control mb-3" name="simage" value="{{old('simage',$subcategory->simage)}}" accept="image/*" onchange=ShowImage(event)>
                    @error('cimage')
                    <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>
                <div class="col-lg-4 col-sm-5 col-6  position-relative mt-3 unhide overflow-hidden">
                    <img id="imgUploadhidden" src="{{asset('images/no image.webp')}}" style="display:none;">
                    @if ($subcategory->simage != Null)
                        <img class="img-fluid imgsize w-100 h-100 object-fit-cover" id="imgUpload" src="{{asset($subcategory->simage)}}" style="transform:{{$subcategory->SAngle}};">
                    @else
                        <img class="img-fluid imgsize w-100 h-100 object-fit-cover" id="imgUpload" src="{{asset('images/no image.webp')}}" style="transform:{{$subcategory->SAngle}};">
                    @endif
                    <script>
                        let imgName;
                        let updateImgInput=document.getElementById("imgUpload").src;
                        console.log(updateImgInput);
                        if(updateImgInput!=""){
                            fetch(updateImgInput)
                            .then(response => response.blob())
                            .then(blob => {
                                imgName=updateImgInput.split('/').pop();
                                // Create a new File from the Blob
                                const file = new File([blob], imgName, { type: blob.type });
                                
                                // Create a DataTransfer object to add the file
                                const dataTransfer = new DataTransfer();
                                dataTransfer.items.add(file);
    
                                // Assign the file to the target input
                                document.getElementById("emptyValue").files = dataTransfer.files;
                            })
                            .catch(error => console.error("Error converting image src to file:", error));
                        }
                       
                    </script>
                    {{--  <div class="row position-absolute BoxEffect w-100 h-100 ">  --}}
                    <div class="position-absolute BoxEffect" id="boxShow">
                        <div class="text">
                            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#staticBackdrop1">
                                <i class="fa-regular fa-pen-to-square fs-4 marginSet" onclick=EditImg()></i>
                            </button>
                        </div>
                        
                    </div>
                    {{--  </div>  --}}
                    @once
                        @include('AdminPages.codeparts.ImgEditCrop')
                    @endonce
                
                </div>
            </div>
        </div>
        {{--  second part of row  --}}
        <div class="col-md-4 col-12 g-2">
            <div class="row">
                {{--  Subcategory status part  --}}
                <div class="col-12 bg-light shadow-sm">
                    <label class="form-label mt-3"><b>SubCategory Status:</b></label>
                    <select class="form-select mb-3" name="sstatus">
                        <option value="Yes" {{old('sstatus', $subcategory->sstatus) == 'Yes' ? 'selected' : ''}}>Active</option>
                        <option value="No" {{old('sstatus', $subcategory->sstatus) == 'No' ? 'selected' : ''}}>Deactive</option>
                    </select>
                </div>
                {{--  Subcategory show on page yes or no  --}}
                <div class="col-12 bg-light shadow-sm mt-3">
                    <label class="mt-3"><b>Show on page:</b></label>
                    <select class="form-select mb-3 mt-3" name="sShowPage">
                        <option value="Yes" {{old('sShowPage', $subcategory->sShowPage) == 'Yes' ? 'selected' : ''}}>Yes</option>
                        <option value="No" {{old('sShowPage', $subcategory->sShowPage) == 'No' ? 'selected' : ''}}>No</option>
                    </select>
                </div>
                {{--  Subcategory parent show on page yes or no  --}}
                <div class="col-12 bg-light shadow-sm mt-3">
                    <label class="mt-3"><b>Parent:</b></label>
                    <select class="form-select mb-3 mt-3" name="categories_id">
                        {{--  @if (!empty($categories))  --}}
                            @foreach ($categories as $category)
                            <option value="{{$category->id}}" {{old('categories_id',$subcategory->categories_id)==$category->id? "selected" : ""}} >{{$category->cname}}</option>
                                
                            {{--  <option value="{{old('categories_id',$subcategory->$categories_id)}}" {{$category->id==$subcategory->$categories_id? "selected" : ""}} >{{$category->cname}}</option>  --}}
                            @endforeach
                            
                        {{--  @endif  --}}
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            {{--  buttons  --}}
            <div class="col-12 mt-4 mb-5">
                <button type="submit" class="btn btn-info">Save</button>
                <button type="button" class="btn btn-success">Cancel</button>
                </form>
            </div>
        </div>
    </div>
@endsection


@section('CustomAction')
    <script src="{{ asset('Admin/js/categorySubAction.js') }}"></script>
@endsection