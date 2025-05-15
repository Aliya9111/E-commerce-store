{{--  <!-- Button trigger modal -->  --}}
<button type="button" class="btn btn-info bg-info border-0 h-75 w-75 ms-auto me-auto" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
  @if ($adminData->image !=NULL)
    <img src="{{asset($adminData->image)}}" class="rounded-circle img-fluid h-100 w-100">
  @else 
    <img src="{{asset('images/profile.jfif')}}" class="rounded-circle img-fluid h-100 w-100">
  @endif
</button>

{{--  <!-- Modal -->  --}}
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      
      <div class="modal-body">
        {{--  card  --}}
        <div class="card border-0">
          <img src="{{asset('images/adminImg.jpg')}}" class="img-fluid w-100 h-50 object-fit-cover">
          <div class="card-body info-font">
              <button class="btn btn-danger">Delete</button>
              <button class="btn btn-primary">Take photo</button>
              <button type="file" class="btn btn-primary">Browse</button>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>