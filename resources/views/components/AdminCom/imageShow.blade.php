@props(['idSet','Image','ImageAngle'])
@if(!empty($Image))
    <button type="button" class="border-0 bg-light" data-bs-toggle="modal" data-bs-target="#exampleModal-{{$idSet}}">
        <img src="{{asset($Image)}}" height="30px" width="30px" title="{{$Image}}" alt="error" style="transform: {{$ImageAngle}}">
    </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal-{{$idSet}}" tabindex="-1" aria-labelledby="exampleModalLabel-{{$idSet}}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel-{{$idSet}}">Modal title</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body overflow-hidden">
            <div class="mt-3 overflow-hidden h-75 w-75">
                <img src="{{asset($Image)}}" class="img-fluid mt-2 h-100 w-100" title="{{$Image}}" alt="Not set" style="transform: {{$ImageAngle}}">
            </div>
            <p class="mt-3">{{$Image}}</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
    </div>
@endif