@extends("AllUsersPages.layouts.topBar")
@section("UserStyleSheet")
    <link rel="stylesheet" href="{{asset('AllUsers/css/ProductsAbout.css')}}">
    <style>
        .backSetColor{
            font-family: sans-serif;
            font-size: 15px;
            opacity: 0.9;
        }
        label{
            font-family: sans-serif;
            font-size: 13px;
            opacity: 0.9;
        }
        .errorP{
            color:red;
            font-size: 13px;
            font-family: sans-serif;
        }
    </style>
@show
@section('timeName','page')
@section('row 2')
<div class="row mb-3 ms-lg-4 ms-sm-2 ms-1 me-lg-4 me-sm-2 me-1" style="margin-top:10px; ">
    <div class="col-12 border" style="background-color: rgb(243, 243, 243);">
        <nav aria-label="breadcrumb" class="" style="transform: translateY(5px)">
            <ol class="breadcrumb bg-transparent">
                <li class="breadcrumb-item"><a href="{{asset(route('Home'))}}" class="">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$pageData->Name}}</li>
            </ol>
        </nav>
    </div>
</div>
@endsection
@if ($pageData->Name=='About')
    @section('row 3')
        <div class="row ms-lg-4 ms-sm-2 ms-1 me-lg-4 me-sm-2 me-1" style="background-color: rgb(243, 243, 243);">
            <div class="col-12">
                <h1 class="mt-3 headingShadow">{{$pageData->Name}}</h1>
                    <div class="fontSetAboute backSetColor CommonLighColor" >
                        {!! $pageData->Description !!}
                    </div>
            </div>
        </div>
    @endsection
    @section('row 4')
        <div class="row justify-content-around mt-3 CommonLighColor ms-lg-4 ms-sm-2 ms-1 me-lg-4 me-sm-2 me-1 pt-3 pb-3">
            <div class="col-md-3 col-sm-4 col-12 ProgressSet gap-2 mb-3">
                <div class="text-center">{{$count}}</div>
                <div class="text-center">Satisfied Customers</div>
            </div>
            <div class="col-md-3 col-sm-4 col-12 ProgressSet gap-2 mb-3">
                <div class="text-center">
                    @if (!empty($countries))
                        {{$countries}} {{$countries < 100 ? '' :'+'}}
                    @else
                        0
                    @endif
                </div>
                <div class="text-center">Countries</div>
            </div>
            <div class="col-md-3 col-sm-4 col-12 ProgressSet ProgressSetEnd gap-2 mb-3">
                <div class="text-center">
                    @if (!empty($products))
                        {{$products}} {{$products < 100 ? '' :'+'}}
                    @else
                        0
                    @endif
                </div>
                <div class="text-center">Products</div>
            </div>

        </div>
    @endsection
@endif    
@if($pageData->Name=='Contact') 
    @section('row 3')
        <div class="row ms-lg-4 ms-sm-2 ms-1 me-lg-4 me-sm-2 me-1" style="background-color: rgb(243, 243, 243);">
            <div class="col-6 p-5">
                <h1 class="mt-3 headingShadow">{{$pageData->Name}}</h1>
                    <p class="fontSetAboute backSetColor CommonLighColor" >
                        {!! $pageData->Description !!}
                    </p>
            </div>
            <div class="col-6 p-5">
                <h2 class="mt-3 headingShadow">Enter Information</h2>
                <div class="mt-1" id="showMessage"></div>
                <form  method="post" id="formData">
                    @csrf
                    @method('post')
                    <label>Name:</label>
                    <input type="text" class="form-control" name="name" id="nameInput">
                    <p id="nameId" class="errorP"></p>
                    <label class="mt-2">Email:</label>
                    <input type="text" class="form-control" name="email" id="emailInput">
                    <p id="emailId" class="errorP"></p>
                    <label class="mt-2">Message:</label>
                    <textarea class="form-control" rows="6" name="message" id="messageInput"></textarea>
                    <p class="errorP" id="messageId"></p>
                    
                    <input type="submit" class="btn btn-primary mt-3" id="btnId">
                </form>
            </div>
        </div>
        
    @endsection  
    @section("ActionSheet")
        <script>
            document.getElementById('formData').addEventListener('submit', function (e) {
                e.preventDefault(); // Prevent the default form submission
                // Create form data
                let formData = new FormData(this);
        
                // Submit the form via AJAX
                jQuery.ajax({
                    url: "{{ route('UserMessage','Contact') }}", // Your POST route
                    type: "POST",
                    data: formData,
                    processData: false, // Don't process the data
                    contentType: false, // Let the browser set the content type
                    success: function (response) {
                        if(response.status==false){
                            console.log("flase condition")
                            var messageTag=`<div class="alert alert-warning alert-dismissible fade show" role="alert">
                                                <strong>Fail!</strong> ${response.message}
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                            `
                            jQuery("#showMessage").html("");
                            jQuery("#showMessage").html(messageTag);

                        }
                        else{
                            var errors=response.errors
                            if(errors.name){
                                jQuery("#nameInput").addClass("is-invalid");
                                jQuery("#nameId").html(errors.name);
                            }
                            else{
                                jQuery("#nameInput").removeClass("is-invalid");
                                jQuery("#nameId").html("");
                            }
                            if(errors.email){
                                jQuery("#emailInput").addClass("is-invalid");
                                jQuery("#emailId").html(errors.email);
                            }
                            else{
                                jQuery("#emailInput").removeClass("is-invalid");
                                jQuery("#emailId").html("");
                            }
                            if(errors.message){
                                jQuery("#messageInput").addClass("is-invalid");
                                jQuery("#messageId").html(errors.message);
                            }
                            else{
                                jQuery("#messageInput").removeClass("is-invalid");
                                jQuery("#messageId").html("");
                            }

                            {{--  if message send show the message  --}}
                            if(errors.length==0){
                                jQuery("#btnId").addClass("disabled");
                                {{--  @php
                                @endphp  --}}
                                jQuery("#btnId").removeClass("disabled");
                                var messageTag=`<div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>Success!</strong> ${response.message}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                `
                                jQuery("#showMessage").html("");
                                jQuery("#showMessage").html(messageTag);
                            }
                        
                        }
                    },
                });
            });
        </script>
    @endsection
@endif
