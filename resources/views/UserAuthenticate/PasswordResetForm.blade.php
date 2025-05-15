@extends('UserAuthenticate.baseAuth')
@section('AuthTiltle','Password Reset')
@section("topMargin",'100px')
@section('commonAuth')
    
    <div class="col-12 justify-content-center text-center mb-3" >
        @if (Session::has('success'))
            <div class="row justify-content-center">
                <div class="col-6">
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Success!</strong>{{Session::get('success')}}.<a href="{{route('login')}}">login</a>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        @endif
        <a class="navbar-brand" href="#" style="font-weight: bold; font-size:20px;font-family:sans-serif; ">
            <i class="fa-solid fa-shop me-1" style="color: rgb(89, 111, 219);font-size:25px;"></i>
           ALIYA ST<i class="fa-brands fa-opera" style="color: rgb(89, 111, 219)"></i>RE
        </a>
    </div>
    <div class="col-4 backcolor p-3">
        <h2 class="text-center text-light AuthHeads" style="font-size: 23px">Password Reset Form</h2> 
        <form method="post" action="{{route('UpdatePassword',$email)}}">
            @csrf
            @method('put')
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
            <div class="justify-content-center text-center">
                <button type="submit" class="btn btn-primary mt-3" style="background-color: rgb(89, 111, 219);font-weight:bold">Reset</button>
            </div>
        </form>  
    </div> 
    <div class="col-12 text-center mt-3">
        <spanstyle="font-size: 13px">Not a Member<a class="ms-1" href="{{asset(route('register'))}}">Register</a></spanstyle=>
    </div>   
@endsection
    