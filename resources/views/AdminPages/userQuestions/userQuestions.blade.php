@extends('AdminPages.layouts.AdminBase')
@section("CustomStyle")
{{--  <link href="{{ asset('Admin/css/categorySub.css') }}" rel="stylesheet">   --}}
<style>
    .badge:hover{
        background-color: black !important;
        cursor: pointer;
    }
</style>
@endsection
@section("title")
  <title>Questions</title>
@endsection 
@section('MainPart')
    {{--  show the form of Add subcategory etc. --}}
    <div class="row mt-3 ms-3 me-3 gy-2 justify-content-around">
        <div class="row">
            <div class="col-12 d-flex">
                <h3>User Questions:</h3>
            </div>
        </div>
        {{--  show questions  --}}
        <div class="col-12 g-2">
            @if (!empty($Questions))
                @foreach ($Questions as $Question)
                    @php
                        $user=$Question->Users;
                    @endphp
                    <div class="d-flex p-2 bg-light shadow-sm mb-3" style="opacity: 0.9;font-size:13px;font-family:sans-serif;">
                        <div class="flex-shrink-0" >
                            @if ($user->image != NULL)
                                <img src="{{asset($user->image)}}" class="img-fluid rounded-circle" style="max-height: 60px;max-width:60px;">
                            @else
                                <img src="{{asset('images/profile.jfif')}}" class="img-fluid rounded-circle" style="max-height: 60px;max-width:60px;">
                            @endif
                            <p class="text-center">{{$user->name}}</p>
                        </div>
                        <div class="flex-grow-1 ms-3 align-content-center">
                            <p>
                                {{$Question->message}}
                                @if ($Question->status == 'seen')
                                    <span class="badge" style="background-color: rgb(81, 81, 224);" onclick="window.location.href='{{route('Question',$Question->id)}}'">View</span>
                                @else
                                    <span class="badge" style="background-color: rgb(240, 63, 63);" onclick="window.location.href='{{route('Question',$Question->id )}}'">View</span>
                                @endif
                        </div>
                    </div>
                @endforeach
                
            @else
                <p class="text-center fw-bold" style="font-size: 25px;opacity:0.7;font-family:sans-serif;">Empty!</p>
            @endif
            
        </div>
    </div>
@endsection


@section('CustomAction')
@endsection