@props(['pid','productImage','AllImages'])
<a class="nav-link"  data-bs-toggle="offcanvas" data-bs-target="#offcanvasTop-{{$pid}}" aria-controls="offcanvasTop-{{$pid}}">
    <img class="pImage img-fluid" src="{{asset("Admin\images\products\uploads\\".$productImage->name)}}">
</a>

<div class="offcanvas offcanvas-top h-100" tabindex="-1" id="offcanvasTop-{{$pid}}" aria-labelledby="offcanvasTopLabel-{{$pid}}">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasTopLabel-{{$pid}}">Products images</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <div class="container-fluid w-100 h-100 ">
        <div class="row">
            <div class="col-12 border text-start">
                @if ($AllImages->isNotEmpty())
                    @foreach ($AllImages as $image)
                        <img src="{{asset("Admin\images\products\uploads\\".$image->name)}}" class="img-fluid me-1"  style="height:100px; width=100px; object-fit:cover;">
                    @endforeach
                @else
                    <h3 class="text-center">Image are not available</h3>
                @endif
            </div>
        </div>
    </div>
  </div>
</div>