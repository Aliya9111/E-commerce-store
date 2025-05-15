@extends('AdminPages.layouts.AdminBase')
@section("CustomStyle")
<link href="{{ asset('Admin/css/DisUser.css') }}" rel="stylesheet"> 
@endsection
@section("title")
  <title>User</title>
@endsection 
@section('BreadCrumb')
    User
@endsection
@section('MainPart')
    {{--  show the form of user --}}
    <div class="row mt-3 ms-3 me-3 gy-2 justify-content-around">
        <div class="row">
            <div class="col-12 d-flex">
                <h3>Add User:</h3>
                <a href="{{route('user')}}" class="btn btn-outline-dark ms-3 btn-sm mt-1 mb-1">Clear data</a>
                <a href="{{route('Allusers')}}" class="btn btn-outline-dark ms-3 btn-sm mt-1 mb-1">Check all</a>
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
                    <form method="POST" action="{{route('Adduser')}}" enctype="multipart/form-data">
                        @csrf
                        {{--  name of the user  --}}
                        <label class="form-label mt-3"><b>Name:</b></label>
                        <input type="text" name="name" placeholder="Enter name of user" value="{{old('name')}}" class="form-control">
                        @error('name')
                            <p class="text-danger">{{$message}}</p>
                        @enderror
                        {{--  email of the user  --}}
                        <label class="form-label @error('name') mt-0 @else mt-3 @enderror"><b>Email:</b></label>
                        <input type="email" name="email" placeholder="Enter the email" value="{{old('email')}}" class="form-control">
                        @error('email')
                            <p class="text-danger">{{$message}}</p>
                        @enderror
                        {{--  Password of the user  --}}
                        <label class="form-label @error('email') mt-0 @else mt-3 @enderror"><b>Password:</b></label>
                        <input type="password" name="password" placeholder="Enter password" class="form-control">
                        @error('password')
                            <p class="text-danger">{{$message}}</p>
                        @enderror
                        {{--  Password of the user  --}}
                        <label class="form-label @error('password') mt-0 @else mt-3 @enderror"><b>Confirm Password:</b></label>
                        <input type="password" name="password_confirmation" placeholder="Rewrite password" class="form-control mb-3">
                        @error('password_confirmation')
                        <p class="text-danger">{{$message}}</p>
                        @enderror
                </div>       
                {{--image part   --}}
                <div class="col-12 bg-light shadow-sm mt-3">
                    <label class="form-label mt-2"><b>Image:</b></label>
                    <input type="hidden" name="rotation-angel1" value="rotate(0deg)" id="angel-set1">
                    <input type="file" id="emptyValue" name="image" data-cropper="" accept="image/*" class="form-control mb-3" onchange=ShowImage(event)>
                    @error('image')
                    <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>
                <div class="col-lg-4 col-sm-5 col-6  position-relative mt-3 unhide overflow-hidden">
                    <img id="imgUploadhidden" src="{{asset('images/profile.jfif')}}" style="display:none;">
                    <img class="img-fluid imgsize w-100 h-100 object-fit-cover" id="imgUpload" src="{{asset('images/profile.jfif')}}" style="transform:rotate(0deg);">
                    {{--  <div class="row position-absolute BoxEffect w-100 h-100 ">  --}}
                    <div class="position-absolute BoxEffect d-none" id="boxShow">
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
                {{--  user gender part  --}}
                <div class="col-12 bg-light shadow-sm">
                    <label class="form-label mt-3"><b>Gender:</b></label>
                    <select class="form-select mb-3" name="gender">
                        <option>Not selected</option>
                        <option value="male" {{old('gender')=='0'? 'selected' : ''}}>Male</option>
                        <option value="female" {{old('gender')=='1'? 'selected' : ''}}>Female</option>
                        <option value="transgender" {{old('gender')=='2'? 'selected' : ''}}>Transgender</option>
                    </select>
                    @error('gender')
                    <p class="text-danger">{{$message}}</p>
                    @enderror
                    {{--  user number  --}}
                    <label class="form-label "><b>Number:</b></label>
                    <div class="input-group">
                        <div class="input-group-text">Flag</div>
                        <input type="tel" name="number" value="{{old('number')}}" class="form-control">
                    </div>
                    @error('number')
                    <p class="text-danger">{{$message}}</p>
                    @enderror
                    {{--  date of birth  --}}
                    <label class="form-label mt-3 "><b>DOB:</b></label>
                    <input type="date" name="dob" value="{{old('dob')}}" class="mb-3 form-control">
                    @error('dob')
                    <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>
               
            </div>
            <div class="row mt-3">
                {{--  user status part  --}}
                <div class="col-12 bg-light shadow-sm">
                    <label class="form-label mt-3"><b>User Status:</b></label>
                    <select class="form-select mb-3" name="status">
                        <option value="user" {{old('status')=='user'? 'selected' : ''}}>User</option>
                        <option value="admin" {{old('status')=='admin'? 'selected' : ''}}>Admin</option>
                    </select>
                </div>
                {{--  user block or unblock  --}}
                <div class="col-12 bg-light shadow-sm mt-3">
                    <label class="mt-3"><b>User Block:</b></label>
                    <select class="form-select mb-3 mt-3" name="UserBlock">
                        <option value="No" {{old('UserBlock')=='No'? 'selected' : ''}}>No</option>
                        <option value="Yes" {{old('UserBlock')=='Yes'? 'selected' : ''}}>Yes</option>
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
    <script src="{{ asset('Admin/js/DisUser.js') }}"></script>
    <script src="{{ asset('Admin/js/categorySubAction.js') }}"></script>
@endsection