@extends('AdminPages.layouts.AdminBase')
@section("CustomStyle")
<link href="{{ asset('ckeditor5/css/ckeditor5.css') }}" rel="stylesheet"> {{---for text editor--}} 
<style>
    .ck-editor__editable {
        height: 200px; /* Adjust the height */
        width: 100%; /* Adjust the width */
    }
</style>
@endsection
@section("title")
  <title>pages</title>
@endsection 
@section('BreadCrumb')
    pages
@endsection
@section('MainPart')
    {{--  show the form of Add category etc. --}}
    <div class="row mt-3 ms-3 me-3 gy-2 justify-content-around">
        <div class="row">
            <div class="col-12 d-flex">
                <h3>Create Page:</h3>
                
                <a href="{{route('Pages.create')}}" class="btn btn-outline-dark ms-3 btn-sm mt-1 mb-1">Clear data</a>
                <a href="{{route('Pages.index')}}" class="btn btn-outline-dark ms-3 btn-sm mt-1 mb-1">Check all</a>
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
                    <form method="POST" action="{{route('Pages.store')}}">
                        @csrf
                        {{--  name of the page  --}}
                        <label class="form-label mt-3"><b>Name:</b></label>
                        <input type="text" name="name" value="{{old('name')}}" class="form-control">
                        @error('name')
                            <p class="text-danger">{{$message}}</p>
                        @enderror
                        {{--  slug of the page  --}}
                        <label class="form-label @error('name') mt-0 @else mt-3 @enderror"><b>Slug:</b></label>
                        <input type="text" name="slug" value="{{old(key: 'slug')}}" class="form-control @error('slug') mb-0 @else mb-3 @enderror ">
                        @error('slug')
                        <p class="text-danger">{{$message}}</p>
                        @enderror
                        <div class="mb-3">
                            <label class="form-label mt-3"><b>Description:</b></label>
                            <textarea class="ck-editor__editable" id="custom-editor" value="{{old('description')}}" name="description"></textarea>
                        </div>
                </div>
            </div>
        </div>
        {{--  second part of row  --}}
        <div class="col-md-4 col-12 g-2">
            <div class="row">
                {{--  page status part  --}}
                <div class="col-12 bg-light shadow-sm">
                    <label class="form-label mt-3"><b>Page Status:</b></label>
                    <select class="form-select mb-3" name="status">
                        <option value="1" selected>Active</option>
                        <option value="0">Deactive</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            {{--  buttons  --}}
            <div class="col-12 mt-4 mb-5">
                <button type="submit" class="btn btn-info">Save</button>
                </form>
            </div>
        </div>
        
        
    </div>
@endsection


@section('CustomAction')
    <script src="{{ asset('ckeditor5/js/ckeditor5.js') }}"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#custom-editor'))
            .catch(error => {
                console.error(error);
            });
        </script>
@endsection
@section("ckeditor")
    <script>
        {{--  $(document).ready(function(){
            $("#summernote").summernote({
                height:250
            });
        })  --}}
        {{--  ClassicEditor
        .create(document.querySelector('#editorPage'), {
            height: '795px',  // Set the height here
            width: '100%',    // Set the width here if needed
        })
        .catch(error => {
            console.error(error);
        });  --}}
    </script>
@endsection