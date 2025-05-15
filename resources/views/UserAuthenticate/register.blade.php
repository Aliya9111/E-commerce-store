@extends('UserAuthenticate.baseAuth')
@section('AuthTiltle','Register')
@section("topMargin",'100px')
@section('commonAuth')
    <div class="col-12 justify-content-center text-center mb-3">
        <a class="navbar-brand" href="#" style="font-weight: bold; font-size:20px;font-family:sans-serif; ">
            <i class="fa-solid fa-shop me-1" style="color: rgb(89, 111, 219);font-size:25px;"></i>
           ALIYA ST<i class="fa-brands fa-opera" style="color: rgb(89, 111, 219)"></i>RE
        </a>
    </div>
    <div class="col-md-4 col-10 backcolor p-3">
        <h2 class="text-center text-light AuthHeads">Register</h2> 
        <form method="post" action="{{route('registerUser')}}" enctype="multipart/form-data">
            @csrf
            <div class="input-group mt-3">
                <div class="input-group-text">
                    <label for=""><i class="fa-solid fa-user"></i></label>
                </div>
                <input type="text" name="name" value="{{old('name')}}" id="" class="form-control" placeholder="Name" style="font-size: 14px;font-family:sans-serif">
            </div>
            @error('name')
                <p class="text-danger mb-0">{{$message}}</p>
            @enderror
            <div class="input-group mt-3">
                <div class="input-group-text">
                    <label for=""><i class="fa-solid fa-envelope"></i></label>
                </div>
                <input type="email" name="email" id="" value="{{old('email')}}" class="form-control" placeholder="Email" style="font-size: 14px;font-family:sans-serif">
            </div>
            @error('email')
                <p class="text-danger mb-0">{{$message}}</p>
            @enderror
            <div class="input-group mt-3">
                <div class="input-group-text">
                    <label for=""><i class="fa-solid fa-lock" ></i></label>
                </div>
                <input type="password" name="password" id="" class="form-control" placeholder="Password" style="font-size: 14px;font-family:sans-serif">
            </div>
            @if ($errors->any())
                @if ($errors->has('password'))
                    <ul>
                        @foreach ($errors->get('password') as $errorPass)
                            <li class="text-danger">{{$errorPass}}</li>
                        @endforeach
                    </ul>
                @endif
            @endif
            <div class="input-group mt-3">
                <div class="input-group-text">
                    <label for=""><i class="fa-solid fa-lock"></i></label>
                </div>
                <input type="password" name="password_confirmation" id="" class="form-control" placeholder="Confirm Password" style="font-size: 14px;font-family:sans-serif">
            </div>
            <div class="form-check mt-3 p-0">
                <input type="radio" name="gender" value="male" {{old('gender')=='male'? 'checked' : ''}}>
                <label class="form-check-label">Male</label>
                <input type="radio"  name="gender" value="female" {{old('gender')=='female'? 'checked' : ''}}>
                <label class="form-check-label">Female</label>
                <input type="radio"  name="gender" value="transgender" {{old('gender')=='transgender'? 'checked' : ''}}>
                <label class="form-check-label">Transgender</label>
            </div>
            <div class="justify-content-center text-center">
                <button type="submit" class="btn btn-primary mt-3" style="background-color: rgb(89, 111, 219);font-weight:bold">Register</button>
            </div>
        </form>  
       
    </div> 
    <div class="col-12 text-center mt-3">
        <span class="mt-3" style="font-size: 16px">Already a Member<a class="ms-1" href="{{asset(route('login'))}}">login</a></span>
    </div>      
@endsection
    