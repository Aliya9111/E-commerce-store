@extends('AllUsersPages.layouts.UsersBase')

@section('timeName','Home')

@section("ActionSheet")
    {{--  <script>
        function addProducts(AddId){
            console.log(AddId)
            jQuery.ajax({
                url: "{{ route('AddFavourite', ':id') }}".replace(':id', AddId),
                type: 'POST', // Use POST for sending data
                data: {
                    _token: "{{ csrf_token() }}" // Add CSRF token for Laravel
                },
                dataType: 'json', // Expected response format
                success: function(response) {
                    if(response.status=='login'){
                        console.log("login")
                        window.location.href="{{route('login')}}";
                    }
                    console.log(response); // Handle the response
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error); // Handle errors
                }
            });
    }
    function AddRemoveFavourite(id){
        console.log(id)
        addProducts(id)
    }  --}}
    

    {{--  </script>  --}}
    <script src="{{asset('AllUsers/js/HomeEvents.js')}}"></script>
    <script src="{{asset('AllUsers/js/home.js')}}"></script>
    
@endsection