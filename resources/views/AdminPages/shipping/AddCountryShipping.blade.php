@extends('AdminPages.layouts.AdminBase')
@section("CustomStyle")
<link href="{{ asset('Admin/css/Shipping.css') }}" rel="stylesheet"> 
@endsection
@section("title")
  <title>Shipping</title>
@endsection 
@section('BreadCrumb')
Shipping
@endsection
@section('MainPart')
    {{--  show the form of Add category etc. --}}
    <div class="row mt-3 ms-3 me-3 gy-2 justify-content-around">
        <div class="row">
            <div class="col-12 d-flex">
                <h3>Add Country:</h3>
                <a href="{{route('Shipping.create')}}" class="btn btn-outline-dark ms-3 btn-sm mt-1 mb-1">Clear data</a>
                <a href="{{route('Shipping.index')}}" class="btn btn-outline-dark ms-3 btn-sm mt-1 mb-1">Check all</a>
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
        {{--  first part of row  --}}
        <div class="col-md-7 col-12 g-2">
            <div class="row">
                <div class="col-12 bg-light shadow-sm">
                    <form method="POST" action="{{route('Shipping.store')}}">
                        @csrf
                        {{--  name of the country  --}}
                        <label class="form-label mt-3"><b>Country Name:</b></label>
                        <input type="text" name="name" value="{{old('name')}}" placeholder="Enter name of country" class="form-control">
                        @error("name")
                            <p class="text-danger">{{$message}}</p>
                        @enderror
                        
                        {{--  code of the country  --}}
                        <label class="form-label @error('name') mt-0 @else mt-3 @enderror"><b>Country Code:</b></label>
                        <input type="text" name="code" value="{{old('code')}}" placeholder="Enter the country code" class="form-control ">
                        @error("code")
                        <p class="text-danger">{{$message}}</p>
                        @enderror
                        
                        {{--  shipping price  --}}
                        <label class="form-label @error('code') mt-0 @else mt-3 @enderror"><b>Shipping Price:</b></label>
                        <input type="text" name="amount" value="{{old('amount')}}" placeholder="Enter Shipping price" class="form-control mb-3">
                        @error("amount")
                        <p class="text-danger">{{$message}}</p>
                        @enderror
                </div>
            </div>
        </div>
        {{--  second part of row  --}}
        <div class="col-md-4 col-12 g-2">
            <div class="row">
                {{--  country status part  --}}
                <div class="col-12 bg-light shadow-sm">
                    <label class="form-label mt-3"><b>Country Status:</b></label>
                    <select class="form-select mb-3" name="Status">
                        <option value="Active" {{old('Status')=="Active" ? 'selected': ''}} selected>Active</option>
                        <option value="Inactive" {{old('Status')=="Inactive" ? 'selected': ''}}>Deactive</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            {{--  buttons  --}}
            <div class="col-12 mb-5 @error('bslug') mt-3 @else mt-4 @enderror">
                <button type="submit" class="btn btn-info">Save</button>
                <button type="button" class="btn btn-success">Cancel</button>
                </form>
            </div>
        </div>
        
    </div>
@endsection


@section('CustomAction')
@endsection