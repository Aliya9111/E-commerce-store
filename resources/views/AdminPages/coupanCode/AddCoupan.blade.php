@extends('AdminPages.layouts.AdminBase')
@section("CustomStyle")
<link href="{{ asset('Admin/css/BrandProduct.css') }}" rel="stylesheet"> 
@endsection
@section("title")
  <title>Coupan</title>
@endsection 
@section('BreadCrumb')
    Coupan
@endsection
@section('MainPart')
    {{--  show the form of Add category etc. --}}
    <div class="row mt-3 ms-3 me-3 gy-2 justify-content-around">
        <div class="row">
            <div class="col-12 d-flex">
                <h3>Add Coupan:</h3>
                <a href="{{route('Coupan.create')}}" class="btn btn-outline-dark ms-3 btn-sm mt-1 mb-1">Clear data</a>
                <a href="{{route('Coupan.index')}}" class="btn btn-outline-dark ms-3 btn-sm mt-1 mb-1">Check all</a>
            </div>
            <div class="col-12 mt-2">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show p-3" role="alert">
                        <strong>Successfully! </strong>{{session('success')}} 
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session('fail'))
                <div class="alert alert-danger alert-dismissible fade show p-3" role="alert">
                    <strong>Fail! </strong>{{session('fail')}} 
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            </div>
        </div>
        {{--  next row  --}}
        <div class="row bg-light shadow-sm">
            <div class="col-md-7 col-12">
                <form method="POST" action="{{route('Coupan.store')}}">
                    @csrf
                    {{--  code of the coupan  --}}
                    <label class="form-label mt-3"><b>Coupan Code:</b></label>
                    <input type="text" name="code" value="{{old('code')}}" placeholder="coupan code" class="form-control inputSize">
                    @error("code")
                        <p class="text-danger">{{$message}}</p>
                    @enderror
                    {{--  name of the coupan  --}}
                    <label class="form-label @error('code') mt-0 @else mt-3 @enderror"><b>Coupan Name:</b></label>
                    <input type="text" name="name" value="{{old('name')}}" placeholder="coupan name" class="form-control inputSize">
                    @error("name")
                    <p class="text-danger">{{$message}}</p>
                    @enderror
                    {{--  description  --}}
                    <label class="form-label @error('name') mt-0 @else mt-3 @enderror"><b>Description:</b></label>
                    <textarea name="description" class="form-control" value="{{old('description')}}" rows="5"></textarea>
                    {{--  max uses  --}}
                    <label class="form-label mt-3"><b>Max Uses:</b></label>
                    <input type="text" name="max_uses" value="{{old('max_uses')}}" placeholder="Enter the max uses" class="form-control inputSize">
                    @error("max_uses")
                    <p class="text-danger">{{$message}}</p>
                    @enderror
                    {{--  max uses user  --}}
                    <label class="form-label @error('max_use') mt-0 @else mt-3 @enderror"><b>Max Users Uses:</b></label>
                    <input type="text" name="max_uses_user" value="{{old('max_uses_user')}}" placeholder="Enter the max uses users" class="form-control inputSize">
                    @error("max_uses_user")
                    <p class="text-danger">{{$message}}</p>
                    @enderror
            </div>
            <div class="col-md-5 col-12">
                {{--  coupan status  --}}
                <label class="form-label mt-3"><b>Status:</b></label>
                <select class="form-select mb-3" name="status">
                    <option value="1" {{old('status')=='1' ? 'selected' :''}} selected>Active</option>
                    <option value="0" {{old('status')=='0' ? 'selected' :''}}>Deactive</option>
                </select>
                {{--  type of amount  --}}
                <label class="form-label mt-0"><b>Type:</b></label>
                <select class="form-select mb-3 " name="type">
                    <option value="fixed" {{old('type')=='fixed' ? 'selected' :''}} class="inputSize">$</option>
                    <option value="percent" {{old('type')=='percent' ? 'selected' :''}} class="inputSize">%</option>
                </select>
                  {{--  discount amount  --}}
                  <label class="form-label mt-0"><b>Discount Amount:</b></label>
                  <input type="text" name="discount_amount" value="{{old('discount_amount')}}" placeholder="Discount Amount" class="form-control inputSize">
                  @error("discount_amount")
                  <p class="text-danger">{{$message}}</p>
                  @enderror
                   {{--  minimum amount  --}}
                   <label class="form-label @error('discount_amount') mt-0 @else mt-3 @enderror"><b>Min Amount:</b></label>
                   <input type="text" name="min_amount"  value="{{old('min_amount')}}"  placeholder="Minimum Amount" class="form-control inputSize">
                   @error("min_amount")
                   <p class="text-danger">{{$message}}</p>
                   @enderror
                    {{-- starts at  --}}
                    <label class="form-label @error('min_amount') mt-0 @else mt-3 @enderror"><b>Starts at:</b></label>
                    <input type="datetime" name="satarts_at" id="startsAt"  value="{{old('satarts_at')}}" placeholder="Starts at" class="form-control inputSize">
                    @error("satarts_at")
                    <p class="text-danger">{{$message}}</p>
                    @enderror
                    {{--  expires  --}}
                    <label class="form-label @error('starts_at') mt-0 @else mt-3 @enderror"><b>Expires at:</b></label>
                    <input type="datetime" name="expires_at" id="expiresAt"  value="{{old('expires_at')}}" placeholder="Expires at" class="form-control inputSize">
                    @error("expires_at")
                    <p class="text-danger">{{$message}}</p>
                    @enderror

        </div>
        <div class="row mt-3">
            {{--  buttons  --}}
            <div class="col-12 mb-5 @error('max_use') mt-3 @else mt-1 @enderror">
                <button type="submit" class="btn btn-info">Save</button>
                <button type="button" class="btn btn-success">Cancel</button>
                </form>
            </div>
        </div>
        
    </div>
@endsection


@section('CustomAction')
    <script>
        jQuery('#startsAt').datetimepicker({});
        jQuery('#expiresAt').datetimepicker({});
    </script>
@endsection