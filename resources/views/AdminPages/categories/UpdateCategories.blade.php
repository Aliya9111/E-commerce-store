@extends('AdminPages.layouts.AdminBase')
@section("CustomStyle")
<link href="{{ asset('Admin/css/categorySub.css') }}" rel="stylesheet"> 
@endsection
@section("title")
  <title>EditCategory</title>
@endsection 
@section('BreadCrumb')
    Edit Category
@endsection
@section('MainPart')
    {{--  show the form of Add category etc. --}}
    <div class="row mt-3 ms-3 me-3 gy-2 justify-content-around">
        <div class="row">
            <div class="col-12 d-flex">
                <h3>Edit Category:</h3>
                <a href="{{route('CategoryUpdateLoad',$category->id)}}" class="btn btn-outline-dark ms-3 btn-sm mt-1 mb-1">Clear data</a>
                <a href="{{route('AllCategries')}}" class="btn btn-outline-dark ms-3 btn-sm mt-1 mb-1">Check all</a>
                
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
                    <form method="POST" action="{{route('CategoryUpdate',(!empty($category->id))? $category->id : "")}}" enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                        {{--  name of the category  --}}
                        <label class="form-label mt-3"><b>Name:</b></label>
                        <input type="text" name="cname" value="{{old('cname',$category->cname)}}" class="form-control">
                        @error('cname')
                            <p class="text-danger">{{$message}}</p>
                        @enderror
                        {{--  slug of the category  --}}
                        <label class="form-label @error('cname') mt-0 @else mt-3 @enderror "><b>Slug:</b></label>
                        <input type="text" name="cslug" value="{{old('cslug',$category->cslug)}}" class="form-control @error('cslug') mb-0 @else mb-3 @enderror">
                        @error('cslug')
                        <p class="text-danger">{{$message}}</p>
                        @enderror
                </div>
                {{--image part   --}}
              
                <div class="col-12 bg-light shadow-sm mt-3">
                    <label class="form-label mt-2"><b>Image:</b></label>
                    <input type="hidden" name="rotation-angel1" value="{{$category->CAngle}}" id="angel-set1">
                    <input type="file" id="emptyValue" class="form-control mb-3" name="cimage" accept="image/*" onchange=ShowImage(event)>
                    @error('cimage')
                    <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>
                    <div class="col-lg-4 col-sm-5 col-6  position-relative mt-3 unhide overflow-hidden">
                        <img id="imgUploadhidden" src="{{asset('images/no image.webp')}}" style="display:none;">
                        @if ($category->cimage != Null)
                            <img class="img-fluid imgsize w-100 h-100 object-fit-cover" id="imgUpload" src="{{asset($category->cimage)}}" style="transform:{{$category->CAngle}};">
                        @else
                            <img class="img-fluid imgsize w-100 h-100 object-fit-cover" id="imgUpload" src="{{asset('images/no image.webp')}}" style="transform:{{$category->CAngle}};">
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
                {{--  @endif  --}}
              
            </div>
        </div>
        {{--  second part of row  --}}
        <div class="col-md-4 col-12 g-2">
            <div class="row">
                {{--  category status part  --}}
                <div class="col-12 bg-light shadow-sm">
                    <label class="form-label mt-3"><b>Category Status:</b></label>
                    <select class="form-select mb-3" name="cstatus">
                        <option value="Yes" {{ old('cstatus', $category->cstatus) == 'Yes' ? 'selected' : '' }}>Active</option>
                        <option value="No" {{ old('cstatus', $category->cstatus) == 'No' ? 'selected' : '' }}>Deactive</option>
                    </select>
                    
                </div>
                {{--  category show on page yes or no  --}}
                <div class="col-12 bg-light shadow-sm mt-3">
                    <label class="mt-3"><b>Show on page:</b></label>
                    <select class="form-select mb-3 mt-3" name="cShowPage">
                        <option value="Yes" {{ old('cstatus', $category->cShowPage) == 'Yes' ? 'selected' : '' }}>Yes</option>
                        <option value="No" {{old('cstatus', $category->cShowPage) == 'No' ? 'selected' : ''}}>No</option>
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