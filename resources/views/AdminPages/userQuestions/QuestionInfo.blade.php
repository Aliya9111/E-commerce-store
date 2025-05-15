@extends('AdminPages.layouts.AdminBase')
@section("CustomStyle")
    <link href="{{ asset('ckeditor5/css/ckeditor5.css') }}" rel="stylesheet"> {{---for text editor--}} 
<style>
    b{
        opacity: 1 !important;
    }
    .ck-editor__editable {
        height: 200px; /* Adjust the height */
        width: 100%; /* Adjust the width */
    }
    .borderRadius{
        height:20px;
        border-left:1px solid black;
        border-bottom-left-radius: 15px;
        position: relative;
    }
    .responsesClass{
        position: absolute;
        top:7px;
        left: 20px;
        font-size: 12px;
    }
</style>
@endsection
@section("title")
  <title>Question</title>
@endsection 
@section('MainPart')
    {{--  show the form of Add subcategory etc. --}}
    <div class="row mt-3 ms-3 me-3 gy-2 justify-content-around">
        <div class="row">
            <div class="col-12 d-flex">
                <h3>User Question:</h3>
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
        {{--  show questions  --}}
        <div class="col-12 g-2">
            <div class="row">
                <div class="col-3 bg-light">
                    @if ($userInfo->image != NULL)
                        <img src="{{asset($userInfo->image)}}" class="img-fluid object-fit-cover" style="max-height:200px;width:100%; object-position: 20% 20%;">
                    @else
                        <img src="{{asset('images/profile.jfif')}}" class="img-fluid object-fit-contain" style="max-height:200px;width:100%;">
                    @endif
                </div>
                <div class="col-4 p-3 bg-light shadow-sm" >
                    <h4 style="font-family:sans-serif;opacity:0.9;">User Imformation</h4>
                    <ul class="list-unstyled" style="font-size:13px;font-family:sans-serif;opacity:0.9;">
                        <li><b>Name: </b>{{$userInfo->name}}</li>
                        <li><b>Email: </b>{{$userInfo->email}}</li>
                        @if ($userInfo->number != NULL)
                            <li><b>Number: </b>{{$userInfo->number}}</li>
                        @endif
                        <li><b>Gender: </b>{{$userInfo->gender}}</li>
                        <li>
                            <a href="{{route('UpdateLoaduser',$userInfo->id)}}">Profile</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12 p-3 bg-light shadow-sm">
                    <h4 style="font-family:sans-serif;opacity:0.9;" class="text-primary">This is the Question of your client</h4>
                    {{$UserQustion->message}}
                    @if ($Responses->isNotEmpty())
                        <div class="borderRadius">
                            <a data-bs-toggle="collapse" class="responsesClass" href="#collapseExampleResponse" aria-expanded="false" aria-controls="collapseExample">
                                Response
                            </a>
                        </div>
                        @foreach ($Responses as $Response)
                            <div class="collapse mt-2 p-0" id="collapseExampleResponse">
                                <div class="card card-body p-2">
                                    {!! $Response->response !!}
                                </div>
                            </div>
                        @endforeach    
                    @endif
                   
                    
                </div>
                
                {{--  <div class="col-12 mt-2 p-2 border-left border-1 border-dark rounded-start-4" style="font-size: 12px;font-family:sans-serif;opacity:0.9;">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Odio incidunt eligendi dolore ipsum, neque nemo voluptates repellendus sunt quo impedit cumque quasi sequi harum voluptas, fugit quaerat possimus aut reprehenderit?
                </div>  --}}
            </div>
            <div class="row mt-3">
                <div class="col-12 p-3 bg-light shadow-sm">
                    <h4 style="font-family:sans-serif;opacity:0.9;" class="text-primary">Write response</h4>
                    <form method="post" action="{{route('response',[$UserQustion->id,$userInfo->id])}}">
                        @csrf
                        @method('patch')
                        <textarea id="QuestioReseditor" name="response" class=".ck-editor__editable"></textarea>
                        @error('response')
                            <p class="text-danger" style="font-size: 12px;">{{$message}}</p>
                        @enderror
                </div>
            </div>
                        <button type="submit" class="btn btn-primary d-inline mt-3 btn-disabled" onsubmit="this.disabled = true;">Send</button>
                    </form>
        </div>
    </div>
@endsection


@section('CustomAction')
<script src="{{ asset('ckeditor5/js/ckeditor5.js') }}"></script>
<script>
   
    ClassicEditor
        .create(document.querySelector('#QuestioReseditor'))
        .catch(error => {
            console.error(error);
        });
</script>

@endsection