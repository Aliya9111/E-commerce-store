@extends("AllUsersPages.layouts.topBar")
@section("UserStyleSheet")
    <link href="{{asset('AllUsers/css/profileCart.css')}}" rel="stylesheet">
    <link href="{{ asset('Admin/css/DisUser.css') }}" rel="stylesheet"> 
    <link href="{{ asset('Admin/css/base.css') }}" rel="stylesheet"> 
    <link href="{{ asset('cropper/cropper.min.css') }}" rel="stylesheet"> {{--for crop image--}}
@show
@section('timeName','Profile')
@section('row 3')
    <div class="row ms-lg-4 ms-sm-2 ms-1 me-lg-4 me-sm-2 me-1 mt-3 CommonLighColor">
        <div class="col-sm-3 col-12 justify-content-center text-center" style="border-right:3px solid white">
            <ol class="list-unstyled list-groug mt-5 gap-3 profileList" >
                <li class="mt-2"><button style="border-bottom: 1px solid rgb(119, 133, 207)" id="btn-1" onclick=ProfileList(event)>Information</button></li>
                <li class="mt-2"><button id="btn-2" onclick=ProfileList(event)>My Orders</button></li>
                <li class="mt-2"><button id="btn-3" onclick=ProfileList(event)>Favourite</button></li>
                <li class="mt-2"><button id="btn-4" onclick=ProfileList(event)>Logout</button></li>
            </ol>
        </div>
        <div class="col-sm-9 col-12" id="listAllPoints">
            <div class="row d-block ms-3 me-3" id="block-1">
                <h4 class="mt-3 text-md-start text-center headingShadow">Personal Information</h4>
                  {{--image part   --}}
                <div class="col-12 bg-light shadow-sm mt-3 d-none">
                    <label class="form-label mt-2"><b>Image:</b></label>
                        <input type="text" name="rotation-angel1" value="{{$user->angle}}" id="angel-set1" form="formId">
                        <input type="file" id="emptyValue" name="image" accept="image/*" class="form-control mb-3" onchange=ShowImage(event) form="formId">
                        @error('image')
                            <p class="text-danger">{{$message}}</p>
                        @enderror
                </div>
                <div class="col-12 mt-3 position-relative mt-3 SetProfileImg unhide overflow-hidden">
                    <div class="userProfileImg overflow-hidden">
                        <img id="imgUploadhidden" src="{{asset('images/profile.jfif')}}" style="display:none;">
                        @if ($user->image)
                            <img class="img-fluid imgsize object-fit-cover" id="imgUpload" src="{{asset($user->image)}}" style="transform:{{$user->angle}};">
                        @else
                            <img class="img-fluid imgsize object-fit-cover" id="imgUpload" src="{{asset('images/profile.jfif')}}" style="transform:rotate(0deg);">
                        @endif
                    </div>
                   
                    <script>
                        let imgName;
                        let updateImgInput=document.getElementById("imgUpload").src;
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
                        }
                    </script>
                    <div class="position-absolute BoxEffect SetProfileImg" id="boxShow">
                        <div class="text">
                            <button type="button" class="bg-transparent" data-bs-toggle="modal" data-bs-target="#staticBackdrop1">
                                <i class="fa-regular fa-pen-to-square fs-4 marginSet pt-1" onclick=EditImg()></i>
                            </button>
                        </div>
                    </div>
                    @once
                        @include('AdminPages.codeparts.ImgEditCrop')
                    @endonce
                </div> 
                <div class="row mt-3 pb-3">
                    <div class="col-md-6 col-12 shadow-sm">
                        <form method="POST" action="{{route('userupdate',$user->id)}}" enctype="multipart/form-data" id="formId">
                            @csrf
                            @method('patch')
                            {{--  name of the user  --}}
                            <label class="form-label mt-3"><b>Name:</b></label>
                            <input type="text" name="name" value="{{old('name',$user->name)}}" class="form-control" style="font-size: 13px;font-family:sans-serif;opacity:0.9">
                            @error('name')
                            <p class="text-danger">{{$message}}</p>
                            @enderror
                            {{--  email of the user  --}}
                            <label class="form-label @error('name') mt-0 @else mt-3 @enderror"><b>Email:</b></label>
                            <input type="email" name="email" value="{{old('email',$user->email)}}" class="form-control" style="font-size: 13px;font-family:sans-serif;opacity:0.9">
                            @error('email')
                                <p class="text-danger">{{$message}}</p>
                            @enderror
                            {{--  user number  --}}
                            <label class="form-label @error('email') mt-0 @else mt-3 @enderror"><b>Number:</b></label>
                            <div class="input-group">
                                <div class="input-group-text">Flag</div>
                                <input type="tel" name="number" value="{{old('number',$user->number)}}" class="form-control" style="font-size: 13px;font-family:sans-serif;opacity:0.9">
                            </div>
                            @error('number')
                            <p class="text-danger">{{$message}}</p>
                            @enderror
                           
                    </div>
                    <div class="col-md-6 col-12 shadow-sm mt-md-0 mt-3" style="border-left:5px solid rgb(243, 243, 243)">
                        <label class="form-label mt-3"><b>Gender:</b></label>
                        <select class="form-select mb-3" name="gender" style="font-size: 13px;font-family:sans-serif;opacity:0.9">
                            <option value="male" {{old('gender',$user->gender)=='male'? 'selected' : ''}}>Male</option>
                            <option value="female" {{old('gender',$user->gender)=='female'? 'selected' : ''}}>Female</option>
                            <option value="transgender" {{old('gender',$user->gender)=='transgender'? 'selected' : ''}}>Transgender</option>
                        </select>
                        @error('gender')
                        <p class="text-danger">{{$message}}</p>
                        @enderror
                        
                        {{--  date of birth  --}}
                        <label class="form-label mt-0"><b>DOB:</b></label>
                        <input type="date" name="dob" value="{{old('dob',$user->dob)}}" class="mb-3 form-control" style="font-size: 13px;font-family:sans-serif;opacity:0.9">
                        @error('dob')
                        <p class="text-danger">{{$message}}</p>
                        @enderror
                        <input type="hidden" name="status" value="{{$user->status}}">
                        <input type="hidden" name="UserBlock" value="{{$user->UserBlock}}">

                    </div>
                </div>
                <div class="row">
                    {{--  buttons  --}}
                    <div class="col-12 mt-2 mb-3 text-center">
                        <button type="submit" class="btn btn-info">Update</button>
                        <button type="reset" class="btn btn-success btnCancel">Cancel</button>
                        </form>
                    </div>
                </div>  
                {{--  user address  --}}
                <div class="row pb-3">
                    <h4 class="text-md-start text-center headingShadow">Address</h4>
                    @if (Session::has('failAddress'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Fail!</strong> {{Session::get('failAddress')}}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if (Session::has('successAddress'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Success!</strong> {{Session::get('successAddress')}}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="col-md-6 col-12 shadow-sm">

                        <form method="POST" action="{{route('updateAddress',$user->id)}}">
                            @csrf
                            @method('patch')
                            {{--  first name of the user  --}}
                            <label class="form-label mt-3"><b>Fist Name:</b></label>
                            <input type="text" class="form-control" name="firstName" value="{{ old('firstName', $address->first_name ?? '') }}" style="font-size: 13px">
                            @error('firstName')
                                <p class="text-danger" style="font-size: 13px;">{{$message}}</p>
                            @enderror
                            {{--  last name of the user  --}}
                            <label class="form-label mt-3"><b>Last Name:</b></label>
                            <input type="text" class="form-control" name="lastName" value="{{ old('lastName', $address->last_name ?? '' )}}" style="font-size: 13px">
                            @error('lastName')
                                <p class="text-danger" style="font-size: 13px;">{{$message}}</p>
                            @enderror
                            {{--  email of the user  --}}
                            <label class="form-label mt-3"><b>Email:</b></label>
                            <input type="text" class="form-control" name="email" value="{{ old('email', $address->email ?? '') }}" style="font-size: 13px">
                            @error('email')
                                <p class="text-danger" style="font-size: 13px;">{{$message}}</p>
                            @enderror
                            {{--  country  --}}
                           <label class="form-label mt-3"><b>Country:</b></label>
                           <select class="form-select" name="CountryId" id="CountryId" style="font-size: 13px;opacity:0.9; font-family:sans-serif;">
                                <option value="none">Select a Country</option>
                                @if (!empty($address))
                                    @if (!empty($countries))
                                        @foreach ($countries as $country)
                                            <option value="{{$country->id}}" {{old('CountryId',$address->country_id) == $country->id? 'selected' : ''}}>{{$country->name}}</option>
                                        @endforeach
                                    @endif
                                @else
                                    @if (!empty($countries))
                                        @foreach ($countries as $country)
                                            <option value="{{$country->id}}" {{old('CountryId')==$country->id ? 'selected' : '' }}>{{$country->name}}</option>
                                        @endforeach
                                    @endif
                                @endif
                            </select>
                            @error('CountryId')
                                <p class="text-danger" style="font-size: 13px;">{{$message}}</p>
                            @enderror
                    </div>
                    <div class="col-md-6 col-12 shadow-sm mt-md-0 mt-3 pb-3" style="border-left:5px solid rgb(243, 243, 243)">
                        {{--  city of the user  --}}
                        <label class="form-label mt-3"><b>City:</b></label>
                        <input type="text" class="form-control" name="city" value="{{old('city',$address->city ?? '')}}" style="font-size: 13px">
                        @error('city')
                                <p class="text-danger" style="font-size: 13px;">{{$message}}</p>
                        @enderror
                        {{--  state of the user  --}}
                        <label class="form-label mt-3"><b>State:</b></label>
                        <input type="text" class="form-control" name="state" value="{{old('state',$address->state ?? '')}}" style="font-size: 13px">
                        @error('state')
                            <p class="text-danger" style="font-size: 13px;">{{$message}}</p>
                        @enderror          
                        {{--  zip code of the user  --}}
                        <label class="form-label mt-3"><b>Zip Code:</b></label>
                        <input type="text" class="form-control" name="zipCode" value="{{$address->zip ?? ''}}" style="font-size: 13px">
                        @error('zipCode')
                            <p class="text-danger" style="font-size: 13px;">{{$message}}</p>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    {{--  buttons  --}}
                    <div class="col-12 mt-2 mb-5 text-center">
                        <button type="submit" class="btn btn-info">Update</button>
                        <button type="reset" class="btn btn-success btnCancel">Cancel</button>
                        </form>
                    </div>
                </div>  
                {{--  user change password  --}}
                <div class="row pb-3">
                    <h4 class="text-md-start text-center headingShadow">Change password</h4>
                    <div class="col-12 shadow-sm">
                        @if (Session::has('fail'))
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <strong>Fail!</strong> {{Session::get('fail')}}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        @if (Session::has('success'))
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <strong>Success!</strong> {{Session::get('success')}}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        <form method="POST" action="{{route('ChangePassword',$user->id)}}">
                            @csrf
                            @method('patch')
                            {{--  Old password  --}}
                            <label class="form-label mt-3"><b>Old Password:</b></label>
                            <input type="password" class="form-control" name="oldPassword" id="oldPassIdInput" style="font-size: 13px">
                            @error('oldPassword')
                                <p class="text-danger" style="font-size: 13px;">{{$message}}</p>
                            @enderror
                            {{--  new password  --}}
                            <label class="form-label mt-3"><b>New Password:</b></label>
                            <input type="password" class="form-control" name="password" id="newPassIdInput" style="font-size: 13px">
                            @error('password')
                                <p class="text-danger" style="font-size: 13px;">{{$message}}</p>
                            @enderror
                            
                            {{-- confirm password  --}}
                            <label class="form-label mt-3"><b>Confirm Password:</b></label>
                            <input type="password" class="form-control" name="password_confirmation" id="confirmPassIdInput" style="font-size: 13px">
                            @error('password_confirmation')
                                <p class="text-danger" style="font-size: 13px;">{{$message}}</p>
                            @enderror
                    </div>
                </div>
                <div class="row">
                    {{--  buttons  --}}
                    <div class="col-12 mt-2 mb-5 text-center">
                        <button type="submit" class="btn btn-info">Update</button>
                        <button type="reset" class="btn btn-success btnCancel">Cancel</button>
                        </form>
                    </div>
                </div>  
            </div>
            <div class="row d-none ms-3 me-3" id="block-2">
                <h2 class="mt-3 text-md-start text-center headingShadow">My Orders</h2>
                @if ($orders->isNotEmpty())
                    <table class="table table-striped mt-2">
                        <thead>
                          <tr>
                            <th scope="col">Order No</th>
                            <th scope="col">Discount</th>
                            <th scope="col">Total</th>
                            <th scope="col">Status</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                            <tr>
                                <td scope="row">
                                    <a data-bs-toggle="modal" href="#staticBackdrop-{{$order->id}}">{{$order->id}}</a>
                                </td>
                                <x-UserComp.orderDetail :order="$order"></x-UserComp.orderDetail>

                                <td>{{$order->discount}}</td>
                                <td>{{$order->grand_total}}</td>
                                @if ($order->status=='pending')
                                    <td>
                                        <span class="bg-danger text-light p-1 rounded-2">pending</span>
                                    </td>
                                @elseif ($order->status=='shipped')
                                    <td>
                                        <span class="bg-primary text-light p-1 rounded-2">shipped</span>
                                    </td>
                                @else
                                    <td>
                                        <span class="bg-success text-light p-1 rounded-2">Delivered</span>
                                    </td>
                                @endif
                                {{--  <td>{{$order->status}}</td>  --}}
                              </tr>
                            @endforeach
                          
                        </tbody>
                    </table>
                @else
                    <div class="col-12 align-items-center" style="background-color: white;padding:30px;border:7px rgb(243, 243, 243) dashed">
                        <h3 class="text-center" style="font-family: sans-serif;opacity:0.9">Empty!</h3>
                    </div>
                @endif
            </div>
            <div class="row d-none  ms-3 me-3" id="block-3">
                <h2 class="mt-3 text-md-start text-center headingShadow">Favourites</h2>
                @if ($favourite_products->isNotEmpty())
                    @foreach ($favourite_products as $favourite_product)
                        @php
                            $product=App\Models\products::where('id',$favourite_product->product_id)->first();
                            $producImg=$product->productImages()->first()
                        @endphp
                        <div class="col-12">
                            <div class="d-flex mb-3 mt-3 bg-light p-2">
                                <div style="max-height:100px;max-width:100px;">
                                    @if ($producImg)
                                        <img src="{{asset('Admin/images/products/uploads/'.$producImg->name)}}" class="w-100 h-100 img-fluid object-fit-contain">
                                    @else
                                        <img src="{{asset('AllUsers/images/no image 2.jpg')}}" class="w-100 h-100 img-fluid object-fit-contain">  
                                    @endif
                                </div>
                                <div style="font-size:13px;" class="ms-2 flex-shrink-1">
                                    <p class="mb-0">{{$product->title}}</p>
                                    <span><b>Price:</b> {{$product->price}}</span>
                                </div>
                                <div class="ms-auto">
                                    <i class="fa-solid fa-heart text-warning" style="font-size: 20px"></i>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @else
                    <div class="col-12 align-items-center" style="background-color: white;padding:30px;border:7px rgb(243, 243, 243) dashed">
                        <h3 class="text-center" style="font-family: sans-serif;opacity:0.9">Empty!</h3>
                    </div>
                @endif
                
            </div>
            <div class="row d-none ms-3 me-3 pb-4" id="block-4">
                <h2 class="mt-3 text-md-start text-center headingShadow">Logout</h2>
                <div class="col-12 justify-content-center justify-items-center text-center" style="background-color: white;padding:20px;border:7px rgb(243, 243, 243) dashed">
                    <p class="text-center">Are you realy logout from this website</p>
                    <div class="d-inline">
                        <button class="btn btn-info" onclick="window.location.href='{{route("logout")}}'">Yes</button>
                        <button class="btn btn-success btnNo" onclick="window.location.href='{{route("UserProfile")}}'">No</button>
                    </div>
                  
                </div>
            </div>

        </div>
    </div>
@endsection

@section("ActionSheet")
    <script src="{{asset('AllUsers/js/profile.js')}}"></script>
    <script src="{{ asset('Admin/js/categorySubAction.js') }}"></script>
    <script src="{{ asset('webcam/webcam.js') }}"></script>
    <script src="{{ asset('cropper/cropper.min.js') }}"></script>
@endsection