@extends('AdminPages.layouts.AdminBase')
@section("CustomStyle")
    <link href="{{ asset('Admin/css/DisUser.css') }}" rel="stylesheet"> 
@endsection
@section("title")
  <title>Edit User</title>
@endsection 
@section('BreadCrumb')
    Edit User
@endsection
@section('MainPart')
    {{--  show the form of user --}}
    <div class="row mt-3 ms-3 me-3 gy-2 justify-content-around">
        <div class="row">
            <div class="col-12 d-flex">
                <h3>Edit User:</h3>
                <a href="{{route('UpdateLoaduser',$user->id)}}" class="btn btn-outline-dark ms-3 btn-sm mt-1 mb-1">Clear data</a>
                <a href="{{route('Allusers')}}" class="btn btn-outline-dark ms-3 btn-sm mt-1 mb-1">Check all</a>
            </div>
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
        {{--  user image  --}}
        <div class="row mt-3">
            <div class="col-12">
                <div class="d-md-flex d-block text-md-start text-center">
                    <div class="flex-shrink-0 overflow-hidden object-fit-contain">
                        @if ($user->image !=NULL)
                            <img class="img-fluid adminedit" src="{{asset($user->image)}}" style="transform:{{$user->angle}};">
                        @else
                            <img class="img-fluid adminedit" src="{{asset('images/profile.jfif')}}" style="transform:{{$user->angle}};">
                        @endif
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <ul class="list-unstyled">
                            <li class=""><b>Name: </b>{{$user->name}}</li>
                            <li><b>Email: </b>{{$user->email}}</li>
                            <span class="d-md-block d-none">
                                <li><b>Number: </b>{{$user->number}}</li>
                                <li><b>DOB: </b>{{$user->dob}}</li>
                                <li><b>Status: </b>
                                    @if ($user->status=='user')
                                        User
                                    @else
                                        Admin    
                                    @endif
                                </li>
                                <li><b>Active: </b>{{$user->UserBlock}}</li>
    
                                <li><b>Gender: </b>
                                    @if($user->gender=='male')
                                        Male
                                    @elseif($user->gender=='female')
                                        Female
                                    @else
                                        Transgender
                                    @endif
                                </li>
                            </span>
                            <a id="showmore" href="#" class="link-opacity-1-hover link-offset-1 d-md-none d-block">more</a>
                            <span class="showContent d-none">
                                <li><b>Number: </b>{{$user->number}}</li>
                                <li><b>DOB: </b>{{$user->dob}}</li>
                                <li><b>Status: </b>
                                    @if ($user->status=='user')
                                        User
                                    @else
                                        Admin    
                                    @endif
                                </li>
                                <li><b>Active: </b>{{$user->UserBlock}}</li>
    
                                <li><b>Gender: </b>
                                    @if($user->gender=='male')
                                        Male
                                    @elseif($user->gender=='female')
                                        Female
                                    @elseif($user->gender=='transgender')
                                        Transgender
                                    @else
                                       Not available
                                    @endif
                                </li>
                                <a id="showless" href="#" class="link-opacity-1-hover link-offset-1 hidecontent">less</a>
                            </span>
                        </ul>
                    </div>
                </div>
            </div>
          </div>
        {{--  first part of row  --}}
        <div class="col-md-7 col-12 g-2">
            <div class="row">
                <div class="col-12 bg-light shadow-sm">
                    <form method="POST" action="{{route('userupdate',(!empty($user->id))? $user->id : "")}}" enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                        {{--  name of the user  --}}
                        <label class="form-label mt-3"><b>Name:</b></label>
                        <input type="text" name="name" value="{{old('name',$user->name)}}" class="form-control">
                        @error('name')
                        <p class="text-danger">{{$message}}</p>
                        @enderror
                        {{--  email of the user  --}}
                        <label class="form-label @error('name') mt-0 @else mt-3 @enderror"><b>Email:</b></label>
                        <input type="email" name="email" value="{{old('email',$user->email)}}" class="form-control">
                        @error('email')
                            <p class="text-danger">{{$message}}</p>
                        @enderror
                        {{--  show set user Password  --}}
                        <label class="form-label @error('email') mt-0 @else mt-3 @enderror"><b>Password:</b></label>
                        <input type="password" value="{{$user->password}}" class="form-control" readonly>
                        {{-- change the Password  --}}
                        <label class="form-label @error('email') mt-0 @else mt-3 @enderror"><b>Password:</b></label>
                        <input type="password" name="password" class="form-control">
                        @error('password')
                        <p class="text-danger">{{$message}}</p>
                        @enderror
                        {{--  confirm Password   --}}
                        <label class="form-label @error('password') mt-0 @else mt-3 @enderror"><b>Confirm Password:</b></label>
                        <input type="password" name="password_confirmation" class="form-control mb-3">
                </div>
                {{--image part   --}}
                <div class="col-12 bg-light shadow-sm mt-3">
                    <label class="form-label mt-2"><b>Image:</b></label>
                    <input type="hidden" name="rotation-angel1" value="{{$user->angle}}" id="angel-set1">
                    <input type="file" id="emptyValue" name="image" accept="image/*" class="form-control mb-3" onchange=ShowImage(event)>
                    @error('image')
                    <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>
                <div class="col-lg-4 col-sm-5 col-6  position-relative mt-3 unhide overflow-hidden">
                    <img id="imgUploadhidden" src="{{asset('images/profile.jfif')}}" style="display:none;">
                    @if ($user->image !=NULL)
                        <img class="img-fluid imgsize w-100 h-100 object-fit-cover" id="imgUpload" src="{{asset($user->image)}}" style="transform:{{$user->angle}};">
                    @else
                        <img class="img-fluid imgsize w-100 h-100 object-fit-cover" id="imgUpload" src="{{asset('images/profile.jfif')}}" style="transform:{{$user->angle}};">
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
                {{--  <div class="col-lg-4 col-sm-5 col-4 position-relative mt-3 d-block unhide overflow-hidden">
                    <img src="{{asset($user->image)}}" class="img-fluid imgsize w-100 h-100" id="imgUpload" style="transform: {{$user->angle}}">
                    <div class="row position-absolute BoxEffect w-100 h-100">
                        <div class="col-12 justify-content-center boxblure text-center align-content-center">
                            <i class="fa-solid fa-trash fs-4 marginSet" onclick=deleteImg()></i>
                        </div>
                    </div>
                
                </div>  --}}

            </div>
        </div>
        {{--  second part of row  --}}
        <div class="col-md-4 col-12 g-2">
            <div class="row">
                 {{--  user gender part  --}}
                 <div class="col-12 bg-light shadow-sm">
                    <label class="form-label mt-3"><b>Gender:</b></label>
                    <select class="form-select mb-3" name="gender">
                        <option value="Not selected" {{old('gender',$user->gender)=='not selected'? 'selected' : ''}}>Not selected</option>
                        <option value="male" {{old('gender',$user->gender)=='male'? 'selected' : ''}}>Male</option>
                        <option value="female" {{old('gender',$user->gender)=='female'? 'selected' : ''}}>Female</option>
                        <option value="transgender" {{old('gender',$user->gender)=='transgender'? 'selected' : ''}}>Transgender</option>
                    </select>
                    @error('gender')
                    <p class="text-danger">{{$message}}</p>
                    @enderror
                    {{--  user number  --}}
                    <label class="form-label "><b>Number:</b></label>
                    <div class="input-group">
                        <div class="input-group-text">Flag</div>
                        <input type="tel" name="number" value="{{old('number',$user->number)}}" class="form-control">
                    </div>
                    @error('number')
                    <p class="text-danger">{{$message}}</p>
                    @enderror
                    {{--  date of birth  --}}
                    <label class="form-label mt-3 "><b>DOB:</b></label>
                    <input type="date" name="dob" value="{{old('dob',$user->dob)}}" class="mb-3 form-control">
                    @error('dob')
                    <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>
                {{--  user status part  --}}
                <div class="col-12 bg-light shadow-sm">
                    <label class="form-label mt-3"><b>User Status:</b></label>
                    <select class="form-select mb-3" name="status">
                        <option value="user" {{ old('status', $user->status) == 'user' ? 'selected' : '' }}>User</option>
                        <option value="admin" {{ old('status', $user->status) == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                </div>
                {{--  user block or unblock  --}}
                <div class="col-12 bg-light shadow-sm mt-3">
                    <label class="mt-3"><b>User Block:</b></label>
                    <select class="form-select mb-3 mt-3" name="UserBlock">
                        <option value="No" {{ old('UserBlock', $user->UserBlock) == 'No' ? 'selected' : '' }}>No</option>
                        <option value="Yes" {{ old('UserBlock', $user->UserBlock) == 'Yes' ? 'selected' : '' }}>Yes</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            {{--  buttons  --}}
            <div class="col-12 mt-2 mb-5">
                <button type="submit" class="btn btn-info">Update</button>
                <button type="reset" class="btn btn-success">Cancel</button>
                </form>
            </div>
        </div>
    </div>
@endsection


@section('CustomAction')
    <script src="{{ asset('Admin/js/DisUser.js') }}"></script>
    <script src="{{ asset('Admin/js/categorySubAction.js') }}"></script>
@endsection