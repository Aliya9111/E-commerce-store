@extends('AdminPages.layouts.AdminBase')
@section("CustomStyle")
<link href="{{ asset('Admin/css/BrandProduct.css') }}" rel="stylesheet"> 
@endsection
@section("title")
  <title>Update Brand</title>
@endsection 
@section('BreadCrumb')
    Edit brand
@endsection
@section('MainPart')
    {{--  show the form of Add category etc. --}}
    <div class="row mt-3 ms-3 me-3 gy-2 justify-content-around">
        <div class="row">
            <div class="col-12 d-flex">
                <h3>Edit Brand:</h3>
                <a href="{{route('BrandUpdateLoad',$brand->id)}}" class="btn btn-outline-dark ms-3 btn-sm mt-1 mb-1">Clear data</a>
                <a href="{{route('AllBrands')}}" class="btn btn-outline-dark ms-3 btn-sm mt-1 mb-1">Check all</a>
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
                    <form method="POST" action="{{route('brandUpdate',$brand->id)}}">
                        @csrf
                        @method('patch')
                        {{--  name of the brand  --}}
                        <label class="form-label mt-3"><b>Name:</b></label>
                        <input type="text" name="bname" value="{{old('bname',$brand->bname)}}" class="form-control">
                        @error('bname')
                        <p class="text-danger">{{$message}}</p>
                        @enderror
                        {{--  slug of the brand  --}}
                        <label class="form-label @error('cname') mt-0 @else mt-3 @enderror"><b>Slug:</b></label>
                        <input type="text" name="bslug"  value="{{old('bslug',$brand->bslug)}}" class="form-control mb-3 @error('bslug') mb-0 @else mb-3 @enderror">
                        @error('bslug')
                        <p class="text-danger">{{$message}}</p>
                        @enderror
                </div>
            </div>
        </div>
        {{--  second part of row  --}}
        <div class="col-md-4 col-12 g-2">
            <div class="row">
                {{--  brand status part  --}}
                <div class="col-12 bg-light shadow-sm">
                    <label class="form-label mt-3"><b>Brand Status:</b></label>
                    <select class="form-select mb-3" name="bstatus">
                        <option value="Yes" {{old('bstatus',$brand->bstatus)=='Yes'? 'selected' : ''}}>Yes</option>
                        <option value="No" {{old('bstatus',$brand->bstatus)=='No'? 'selected' : ''}}>No</option>
                    </select>
                </div>
                {{--  brand products show on page yes or no  --}}
                <div class="col-12 bg-light shadow-sm mt-3">
                    <label class="mt-3"><b>Show on page:</b></label>
                    <select class="form-select mb-3 mt-3" name="bShowPage">
                        <option value="Yes" {{old('bShowPage',$brand->bShowPage)=='Yes'? 'selected' : ''}}>Yes</option>
                        <option value="No" {{old('bShowPage',$brand->bShowPage)=='No'? 'selected' : ''}}>No</option>
                    </select>
                </div>
               

            </div>
        </div>
        <div class="row">
            {{--  buttons  --}}
            <div class="col-12 mt-0">
                <button type="submit" class="btn btn-info">Save</button>
                <button type="button" class="btn btn-success">Cancel</button>
                </form>
            </div>
        </div>
    </div>
@endsection


@section('CustomAction')
@endsection