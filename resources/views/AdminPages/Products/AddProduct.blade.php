@extends('AdminPages.layouts.AdminBase')
@section("CustomStyle")
<link href="{{ asset('Admin/css/BrandProduct.css') }}" rel="stylesheet"> 
<link href="{{ asset('ckeditor5/css/ckeditor5.css') }}" rel="stylesheet"> {{---for text editor--}} 
<style>
    .ck-editor__editable {
        height: 200px; /* Adjust the height */
        width: 100%; /* Adjust the width */
    }
</style>

@endsection
@section("title")
  <title>Product</title>
@endsection 
@section("BreadCrumb")
  Add Product
@endsection
@section('MainPart')
    {{--  show the form of Add product etc. --}}
    <div class="row mt-3 ms-3 me-3 gy-2 justify-content-around">
        <div class="row">
            <div class="col-12 d-flex">
                <h3>Add Product:</h3>
                
                <a href="{{route('product')}}" class="btn btn-outline-dark ms-3 btn-sm mt-1 mb-1">Clear data</a>
                <a href="{{route('productLoad')}}" class="btn btn-outline-dark ms-3 btn-sm mt-1 mb-1">Check all</a>
            
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
                    <form method="POST" action="{{route('ProductAdd')}}" enctype="multipart/form-data" id="Form-id" onsubmit=AttributeCounter()>
                        @csrf
                        {{--  name of the product  --}}
                        <label class="form-label mt-3"><b>Title:</b></label>
                        <input type="text" name="title" value="{{old('title')}}" placeholder="Enter title of product" class="form-control">
                        @error('title')
                        <p class="text-danger">{{$message}}</p>
                        @enderror
                        {{--  slug of the product  --}}
                        <label class="form-label mt-3"><b>Slug:</b></label>
                        <input type="text" name="slug" value="{{old('slug')}}" placeholder="Enter the slug" class="form-control">
                        @error('slug')
                        <p class="text-danger">{{$message}}</p>
                        @enderror
                        {{--  short description  --}}
                        <label class="form-label mt-3"><b>Short Description:</b></label>
                        <textarea class="custom-editor1 border border-danger ck-editor__editable" value="{{old('ShortDescription')}}" name="ShortDescription" id="custom-editor1" ></textarea>
                        @error('ShortDescription')
                        <p class="text-danger">{{$message}}</p>
                        @enderror   
                        {{--  detaild description  --}}
                        <label class="form-label mt-3"><b>Description:</b></label>
                        <textarea class="custom-editor2 ck-editor__editable" id="custom-editor2" value="{{old('Description')}}" name="Description" ></textarea>
                        @error('Description')
                        <p class="text-danger">{{$message}}</p>
                        @enderror   
                        {{--  Shipping and Return --}}
                        <div class="mb-3">
                            <label class="form-label mt-3"><b>Shipping and Return:</b></label>
                            <textarea class="custom-editor3 ck-editor__editable" id="custom-editor3" value="{{old('Shipping_returns')}}" name="Shipping_returns"></textarea>
                        </div>
                        @error('Shipping_returns')
                        <p class="text-danger">{{$message}}</p>
                        @enderror 
                        {{-- image part   --}}
                        <div class="row">
                            <div class="col-12 bg-light shadow-sm mt-1">
                                <label class="form-label mt-2"><b>Image:</b></label>
                                <div id="image" class="dropzone dz-clickable mb-3">
                                    <div class="dz-message needsclick">    
                                        <br>Drop files here or click to upload.<br><br>                                            
                                    </div>
                                </div>
                                
                            </div>
                            {{--  product  gallery  --}}
                            <div class="row mt-3 g-2" id="product-gallery">
                                @if (old("images"))
                                    @foreach (old("images") as $imageId)
                                        {{--  get temp images base on id if form submission fail --}}
                                        @php
                                            $tempImage=App\Models\tempImages::find($imageId);
                                        @endphp
                                            <div class="col-md-3 mt-3" id="image-row-{{$tempImage->id}}">
                                                <div class="card">
                                                    <input type="text" name="images[]" value="{{$tempImage->id}}">
                                                    <img src="{{asset('Admin/images/products/temp/'.$tempImage->Name)}}" class="card-img-top img-fluid" style="height:100px;object-fit:cover;">
                                                    <div class="card-body">
                                                        <a class="btn btn-danger" onclick=deleteImage({{$tempImage->id}})>Delete</a>
                                                        {{--  <button onclick=deleteImage(${response.image_id}) class="btn btn-danger">Delete</button>  --}}
                                                    </div>
                                                </div>
                                            </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                 
                    </div>

                {{--pricing part    --}}
                <div class="col-12 bg-light shadow-sm mt-3">
                    <h3 class="mt-3 opacity-75">Pricing</h3>
                    <label class="form-label mt-2"><b>Price:</b></label>
                    <input type="text" class="form-control" name="price"  value="{{old('price')}}" placeholder="Enter price">
                    @error('price')
                    <p class="text-danger">{{$message}}</p>
                    @enderror   
                    
                    <label class="form-label mt-3"><b>Compare Price:</b></label>
                    <input type="text" class="form-control mb-4" name="compare_price"  value="{{old('compare_price')}}" placeholder="Enter compare price">
                    @error('compare_price')
                    <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>

                {{--inventry part    --}}
                <div class="col-12 bg-light shadow-sm mt-3">
                    <h3 class="mt-3 opacity-75">Inventry</h3>
                    <div class="row">
                        <div class="col-lg-6 col-12">
                            <label class="form-label mt-3"><b>SKU (Stock Keeping Unit):</b></label>
                            <input type="text" class="form-control" name="sku" value="{{old('sku')}}" placeholder="Enter SKU">
                            @error('sku')
                            <p class="text-danger">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="col-lg-6 col-12">
                            <label class="form-label mt-3"><b>Barcode:</b></label>
                            <input type="text" class="form-control" name="barcode" value="{{old('barcode')}}" placeholder="Enter barcode">
                            @error('barcode')
                            <p class="text-danger">{{$message}}</p>
                            @enderror
                        </div>
                    </div>
                    {{--  product quantity part  --}}
                    <div class="form-check mt-3 mb-3">
                        <input type="checkbox" hidden  name="track_qty" value="off" checked>
                        <input type="checkbox" {{old('track_qty')=='on'? 'checked' : ''}} name="track_qty" class="form-check-input" placeholder="Enter quantity of product">
                        <label class="form-check-label" >Track Quantity</label>
                        
                    </div>
                    <input type="number" class="form-control mb-3" value="{{old('quantity')}}" min="0" name="quantity">
                    @error('quantity')
                        <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>

                {{--Related products    --}}
                <div class="col-12 bg-light shadow-sm mt-3 mb-3">
                    <label class="mt-3 mb-2"><b>Related Products</b></label>
                    <div class="card border-0">
                        <div class="card-body">
                            <select multiple class="related_products w-100"  name="relatedProducts[]" id="relatedProducts">
                                @if(old('relatedProducts'))
                                    @foreach(old('relatedProducts') as $relatedProduct)
                                        {{--  fetch product base on id  --}}
                                        @php
                                            $RelatedProductFetch=\App\Models\products::find($relatedProduct);
                                        @endphp

                                        @if ($RelatedProductFetch)
                                            <option value="{{ $RelatedProductFetch->id }}" selected>{{ $RelatedProductFetch->title }}</option>
                                        @endif
                                    @endforeach
                                @endif  
                            </select>
                        </div>
                    </div>
                    @error('relatedProducts')
                        <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>
            </div>
        </div>
        {{--  second part of row status,categories, subcategories,product,Featured Product  --}}
        <div class="col-md-4 col-12 g-2">
            <div class="row">
                {{--  product status part  --}}
                <div class="col-12 bg-light shadow-sm">
                    <label class="mt-3 mb-2"><b>Product Status:</b></label>
                    <select class="form-select mb-3" name="pstatus">
                        <option value="Yes" {{old('pstatus')=='Yes'? 'selected' : ''}}>Active</option>
                        <option value="No" {{old('pstatus')=='No'? 'selected' : ''}}>Deactive</option>
                    </select>
                </div>
                {{--  categories, subcategories part  --}}
                @if(!empty($categories))
                    <div class="col-12 bg-light shadow-sm mt-3">
                        <h4 class="opacity-75 mt-3">Products Categories:</h4>
                        <label class="mt-3 mb-2"><b>Categories</b></label>
                        <select class="form-select mb-3" name="categories_id" onchange=SetSubcategories(event)>
                            <option value="none">None</option>
                            @foreach ($categories as $category)
                                <option value="{{$category->id}}" {{old("categories_id")==$category->id? 'selected' : ''}} data-category="{{ json_encode($category) }}">{{$category->cname}}</option>
                            @endforeach
                        </select>
                        @error('categories_id')
                        <p class="text-danger">{{$message}}</p>
                        @enderror
                        {{--  subcategories of categories  --}}
                        <label class="mt-3 mb-2"><b>Sub Categories</b></label>
                        <select class="form-select mb-3" name="Subcategories_id" id="DynamicSet">
                            <option value="none">None</option>
                            @if(old("categories_id"))
                                @php
                                    $subcategories=App\Models\categories::where("id",old("categories_id"))->with("Subcategories")->first()->Subcategories ?? [];
                                @endphp
                                {{--  check the subcategories of category are available if yes then append the option tags inside the select this proccess occur after the form submission failure so show the old add subcategory filed  --}}
                                @if (!empty($subcategories))
                                    @foreach ($subcategories as $subcategory)
                                        <option value="{{$subcategory->id}}" {{old('Subcategories_id')==$subcategory->id? 'selected' : ''}}>{{$subcategory->sname}}</option>
                                    @endforeach
                                @endif
                            @endif
                        </select>
                    </div>
                @endif
                {{--  product brands  --}}
                @if(!empty($brands))
                <div class="col-12 bg-light shadow-sm mt-3">
                    <h4 class="opacity-75 mt-3">Products Brands:</h4>
                    <label class="mt-3"><b>Brands:</b></label>
                    <select class="form-select mb-3 mt-2" name="brands_id">
                        <option value="none">None</option>
                        @foreach ($brands as $brand)
                            <option value="{{$brand->id}}" {{old('brands_id')==$brand->id? 'selected' : ''}} >{{$brand->bname}}</option>
                        @endforeach
                    </select>
                </div>
                @endif
                {{--  featured products  --}}
                <div class="col-12 bg-light shadow-sm mt-3 ">
                    <label class="mt-3 mb-2"><b>Featured Product:</b></label>
                    <select class="form-select mb-3" name="ProductFeature">
                        <option value="Yes" {{old('ProductFeature')=="Yes"? 'selected' : ''}}>Yes</option>
                        <option value="No"  {{old('ProductFeature')=="No"? 'selected' : ''}}>No</option>
                    </select>
                </div>

               
                {{--  show the imput field
                <div class="col-12 bg-light shadow-sm mt-3 mb-3" id="SetFieldsShow">
                    
                </div>  --}}
            </div>
        </div>
        <div class="row">
            {{--  buttons  --}}
            <div class="col-12 mt-4 mb-5">
                <button type="submit" id="btnSetDis" class="btn btn-info">Save</button>
                <button type="button" class="btn btn-success">Cancel</button>
                </form>
            </div>
        </div>
    </div>
@endsection
@section("ckeditor")
    <script src="{{ asset('ckeditor5/js/ckeditor5.js') }}"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#custom-editor1'))
            .catch(error => {
                console.error(error);
            });
        ClassicEditor
        .create(document.querySelector('#custom-editor2'))
        .catch(error => {
            console.error(error);
        });
        ClassicEditor
        .create(document.querySelector('#custom-editor3'))
        .catch(error => {
            console.error(error);
        });
    </script>
@endsection
@section("dropZoneImages")
    <script>
        Dropzone.autoDiscover = false;    
        const dropzone = jQuery("#image").dropzone({ 
            init: function() {
                this.on('addedfile', function(file) {
                    {{--  if (this.files.length > 1) {
                        this.removeFile(this.files[0]);
                    }  --}}
                });
            },
            url:  "{{ route('tempimages') }}",
            maxFiles: 10,
            paramName: 'image',
            addRemoveLinks: true,
            acceptedFiles: "image/jpeg,image/png,image/gif",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }, 
            success: function(file, response){
                {{--  $("#image_id").val(response.image_id);  --}}
                let productCard=`<div class="col-md-3 mt-3" id="image-row-${response.image_id}">
                    <div class="card">
                        <input type="hidden" name="images[]" value="${response.image_id}">
                        <img src="${response.imagePath}" class="card-img-top img-fluid" style="height:100px;object-fit:cover;">
                        <div class="card-body">
                            <ul id="${response.image_id}"></ul>
                            <a onclick="deleteImage('${response.image_id}')" class="btn btn-danger btn-sm">Delete</a>
                        </div>
                    </div>
                </div>`
                jQuery("#product-gallery").append(productCard);

                {{--  show the error messages of image  --}}
                if(!response.status){
                    for(let error of response.error){
                        let ultag=document.getElementById(response.image_id);
                        let itag = document.createElement('li');
                        itag.classList.add('text-danger','removeList');
                        itag.textContent = error; // Set the error message as text
                        ultag.append(itag);
                    }
                    let btnTag=document.getElementById("btnSetDis");
                    if(!btnTag.hasAttribute("disabled")){
                        btnTag.setAttribute("disabled","disabled");
                    }
                }
            },
            {{--  delete the images in upload section after append each card  --}}
            complete: function(file){
                this.removeFile(file);
            }
        });
  
    </script>
@endsection
@section('relateddata')
    <script>
        $('.related_products').select2({
            ajax: {
                url: '{{ route("RelatedProductsLoad") }}',
                dataType: 'json',
                tags: true,
                multiple: true,
                minimumInputLength: 3,
                processResults: function (data) {
                    return {
                        results: data.tags
                    };
                }
            }
        }); 
    </script>
    
@endsection
@section('CustomAction')
    <script src="{{ asset('Admin/js/BrandProduct.js') }}"></script>
    

@endsection
