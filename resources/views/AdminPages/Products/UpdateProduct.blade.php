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
  <title>EditProduct</title>
@endsection 
@section("BreadCrumb")
    Edit Product
@endsection
@section('MainPart')
    {{--  show the form of Add product etc. --}}
    <div class="row mt-3 ms-3 me-3 gy-2 justify-content-around">
        <div class="row">
            <div class="col-12 d-flex">
                <h3>Edit Product:</h3>
                <a href="{{route('ProductUpdateLoad',$product->id)}}" class="btn btn-outline-dark ms-3 btn-sm mt-1 mb-1">old data</a>
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
                    <form method="POST" action="{{route('ProductUpdate',(!empty($product->id))? $product->id : "")}}" id="Form-id" onsubmit=AttributeCounter()>
                        @csrf
                        @method('patch')
                        {{--  name of the product  --}}
                        <label class="form-label mt-3"><b>Title:</b></label>
                        <input type="text" name="title" value="{{old('title',$product->title)}}" class="form-control">
                        @error('title')
                            <p class="text-danger">{{$message}}</p>
                        @enderror
                        {{--  slug of the product  --}}
                        <label class="form-label mt-3"><b>Slug:</b></label>
                        <input type="text" name="slug" value="{{old('slug',$product->slug)}}" class="form-control">
                        @error('slug')
                        <p class="text-danger">{{$message}}</p>
                        @enderror   
                       
                        {{--  short description  --}}
                       <label class="form-label mt-3"><b>Short Description:</b></label>
                       <textarea class="custom-editor1 border border-danger ck-editor__editable" id="custom-editor1" value="{{old('ShortDescription',$product->ShortDescription)}}" name="ShortDescription" ></textarea>
                       @error('ShortDescription')
                       <p class="text-danger">{{$message}}</p>
                       @enderror   
                       
                       {{--  detaild description  --}}
                       <label class="form-label mt-3"><b>Description:</b></label>
                       <textarea class="custom-editor2 ck-editor__editable" id="custom-editor2" value="{{old('Description',$product->Description)}}" name="Description" ></textarea>
                       @error('Description')
                       <p class="text-danger">{{$message}}</p>
                       @enderror   
                       {{--  Shipping and Return --}}
                       <div class="mb-3">
                           <label class="form-label mt-3"><b>Shipping and Return:</b></label>
                           <textarea class="custom-editor3 ck-editor__editable" id="custom-editor3" value="{{old('Shipping_returns',$product->Shipping_returns)}}" name="Shipping_returns"></textarea>
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
                                @php
                                    $images=$product->productImages;
                                @endphp
                                @if (!empty($images))
                                    @foreach ($images as $image)
                                        <div class="col-md-3 mt-3" id="image-row-{{$image->id}}">
                                            <div class="card">
                                                <input type="hidden" name="images[]" value="{{$image->id}}">
                                                <img src="{{asset('Admin/images/products/uploads/'.$image->name)}}" class="card-img-top img-fluid" style="height:100px;object-fit:cover;">
                                                <div class="card-body">
                                                    <a class="btn btn-danger" onclick=deleteTempImage({{$image->id}})>Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    
                                @endif
                          
                                @if (!empty(old("images")))
                                    @php
                                        $imagesNew=old("images");
                                        $imagesNew=array_unique($imagesNew);
                                    @endphp    
                                    @foreach ($imagesNew as $image)
                                        @php
                                            $getImg=App\Models\tempImages::where("id",$image)->first();
                                        @endphp
                                        @if($getImg)  
                                            <div class="col-md-3 mt-3" id="image-row-{{$getImg->id}}">
                                                <div class="card">
                                                    <input type="hidden" name="images[]" value="{{$getImg->id}}">
                                                    <img src="{{asset('Admin/images/products/temp/'.$getImg->Name)}}" class="card-img-top img-fluid" style="height:100px;object-fit:cover;">
                                                    <div class="card-body">
                                                        <a class="btn btn-danger" onclick=deleteImage({{$getImg->id}})>Delete</a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                       
                                    @endforeach
                                @endif
                           </div>
                        </div>
                </div>

                {{--pricing part    --}}
                <div class="col-12 bg-light shadow-sm mt-3">
                    <h3 class="mt-3 opacity-75">Pricing</h3>
                    <label class="form-label mt-2"><b>Price:</b></label>
                    <input type="text" class="form-control" name="price"  value="{{old('price',$product->price)}}" placeholder="Enter price">
                    @error('price')
                    <p class="text-danger">{{$message}}</p>
                    @enderror   
                    
                    <label class="form-label mt-3"><b>Compare Price:</b></label>
                    <input type="text" class="form-control mb-4" name="compare_price"  value="{{old('compare_price',$product->compare_price)}}" placeholder="Enter compare price">
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
                            <input type="text" class="form-control" name="sku" value="{{old('sku',$product->sku)}}" placeholder="Enter SKU">
                            @error('sku')
                            <p class="text-danger">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="col-lg-6 col-12">
                            <label class="form-label mt-3"><b>Barcode:</b></label>
                            <input type="text" class="form-control" name="barcode" value="{{old('barcode',$product->barcode)}}" placeholder="Enter barcode">
                            @error('barcode')
                            <p class="text-danger">{{$message}}</p>
                            @enderror
                        </div>
                    </div>
                    {{--  product quantity part  --}}
                    <div class="form-check mt-3 mb-3">
                        <input type="checkbox" hidden  name="track_qty" value="off" checked>
                        <input type="checkbox" {{old('track_qty',$product->track_qty)=='on'? 'checked' : ''}} name="track_qty" class="form-check-input" placeholder="Enter quantity of product">
                        <label class="form-check-label" >Track Quantity</label>
                    </div>
                    <input type="number" class="form-control mb-3" value="{{old('quantity',$product->quantity)}}" min="0" name="quantity">
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
                                {{--  @if(!empty($relProducts))  --}}
                                    @foreach($relProducts as $relProduct)
                                        {{--  fetch product base on id  --}}
                                        @php
                                            $RelatedProductFetch=\App\Models\products::find($relProduct);
                                        @endphp

                                        @if ($RelatedProductFetch)
                                            <option value="{{ $RelatedProductFetch->id }}" selected>{{ $RelatedProductFetch->title }}</option>
                                        @endif
                                    @endforeach
                                {{--  @endif  --}}
                            </select>
                        </div>
                    </div>
                    @error('relatedProducts')
                        <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>
            </div>
        </div>
        {{--  second part of row  --}}
        <div class="col-md-4 col-12 g-2">
            <div class="row">
                {{--  product status part  --}}
                <div class="col-12 bg-light shadow-sm">
                    <h4 class="opacity-75 mt-3">Product Status:</h4>
                    <select class="form-select mb-3" name="pstatus">
                        <option value="Yes" {{old('pstatus',$product->pstatus)=='Yes'? 'selected' : ''}}>Active</option>
                        <option value="No" {{old('pstatus',$product->pstatus)=='No'? 'selected' : ''}}>Deactive</option>
                    </select>
                </div>
                {{--  product categories, subcategories part  --}}
                @if(!empty($categories))
                    <div class="col-12 bg-light shadow-sm mt-3">
                        <h4 class="opacity-75 mt-3">Products Categories:</h4>
                        <label class="mt-3 mb-2"><b>Categories</b></label>
                        <select class="form-select mb-3" name="categories_id" onchange=SetSubcategories(event)>
                            <option value="none">None</option>
                            @foreach ($categories as $category)
                                <option value="{{$category->id}}" {{old("categories_id",$product->categories_id)==$category->id? 'selected' : ''}} data-category="{{ json_encode($category) }}">{{$category->cname}}</option>
                            @endforeach
                        </select>
                        @error('categories_id')
                        <p class="text-danger">{{$message}}</p>
                        @enderror
                        {{--  get the subcategories of category  --}}
                        @php
                            $savecategory=$categories->where("id",$product->categories_id)->first();
                        @endphp
                        <label class="mt-3 mb-2"><b>Sub Categories</b></label>
                        <select class="form-select mb-3" name="Subcategories_id" id="DynamicSet">
                            <option value="none">None</option>
                            @if (!empty($savecategory))
                                @foreach ($savecategory->Subcategories as $subcategory)
                                    <option value="{{$subcategory->id}}" {{old('Subcategories_id',$product->Subcategories_id)==$subcategory->id? 'selected' : ''}}>{{$subcategory->sname}}</option>
                                @endforeach
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
                            <option value="{{$brand->id}}" {{old('brands_id',$product->brands_id)==$brand->id? 'selected' : ''}} >{{$brand->bname}}</option>
                        @endforeach
                    </select>
                </div>
                @endif
                {{--  featured products  --}}
                <div class="col-12 bg-light shadow-sm mt-3 ">
                    <h4 class="opacity-75 mt-3">Featured Product:</h4>
                    <select class="form-select mb-3" name="ProductFeature">
                        <option value="Yes" {{old('ProductFeature',$product->ProductFeature)=="Yes"? 'selected' : ''}}>Yes</option>
                        <option value="No"  {{old('ProductFeature',$product->ProductFeature)=="No"? 'selected' : ''}}>No</option>
                    </select>
                </div>
            </div>
        </div>
     
        <div class="row">
            {{--  buttons  --}}
            <div class="col-12 mt-4 mb-5">
                <button type="submit" id="btnSetDis" class="btn btn-info">Update</button>
                <button type="button" class="btn btn-success">Cancel</button>
                </form>
            </div>
        </div>
    </div>
@endsection
@section("dropZoneImages")
    <script>
        Dropzone.autoDiscover = false;    
        const dropzone = $("#image").dropzone({ 
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
                            <ul id="${response.image_id}" ></ul>
                            <a onclick="deleteImage('${response.image_id}')" class="btn btn-danger btn-sm">Delete</a>

                        </div>
                    </div>
                </div>`
                $("#product-gallery").append(productCard);
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
            },
           
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
    <script src="{{ asset('ckeditor5/js/ckeditor5.js') }}"></script>

    <script>
        function deleteTempImage(PerImage){
            let getTag=document.getElementById("image-row-"+PerImage);
            getTag.remove();
            let url=window.location.origin + '/Product/deleteImg/' +PerImage;
            // Send a DELETE request using fetch
            fetch(url, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Laravel requires CSRF token
                }
            })
        }
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