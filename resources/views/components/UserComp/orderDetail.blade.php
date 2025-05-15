@props(['order'])
@php
    
  $orderItems=App\Helper\Helper::orderDetails($order->id);
@endphp
<div class="modal fade" id="staticBackdrop-{{$order->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel-{{$order->id}}" aria-hidden="true" style="opacity:0.9;font-family:sans-serif">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel-{{$order->id}}">Order Detail</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" style="overflow-x: scroll">
        <div class="d-flex justify-content-between p-2" style="background-color: rgb(243, 243, 243);">
          <div style="flex-grow:1" class="text-center">
            <p style="font-size: 15px" class="mb-0"><b>Order no</b></p>
            <p style="font-size: 13px" class="mb-0">{{$order->id}}</p>
          </div>
          <div style="flex-grow:1" class="text-center">
            <p style="font-size: 15px" class="mb-0"><b>Order date</b></p>
            <p style="font-size: 13px" class="mb-0">{{$order->created_at}}</p>
          </div>
          <div style="flex-grow:1" class="text-center">
            <p style="font-size: 15px" class="mb-0"><b>Total</b></p>
            <p style="font-size: 13px" class="mb-0">{{$order->grand_total}}</p>
          </div>
          <div style="flex-grow:1" class="text-center">
            <p style="font-size: 15px" class="mb-0"><b>Discount</b></p>
            <p style="font-size: 13px" class="mb-0">{{$order->discount}}</p>
          </div>
        </div>
        <div class="mt-2 p-2" style="background-color: rgb(243, 243, 243);">
            <h6 class="border-bottom border-2 border-dark"><b>Order Items</b></h6>
            @foreach ($orderItems as $orderItem)
                @php
                    $Productimage=App\Models\productImages::where('products_id',$orderItem->products_id)->first();
                @endphp
                <div class="d-flex mb-1 mt-3">
                  <div style="height:100px;width:100px;" class="border">
                    <img src="{{ asset('Admin/images/products/uploads/' . $Productimage->name) }}"  style="height: 100%;width:100%;" class="img-fluid object-fit-cover">
                  </div>
                  <div style="font-size:13px;" class="ms-2">
                    <p class="mb-0">{{$orderItem->name}}</p>
                    <ol class="list-unstyled d-flex gap-3">
                      <li><b>Quantity:</b> {{$orderItem->Quantity}}</li>
                      <li><b>Price:</b> {{$orderItem->total}}</li>
                    </ol>
                  </div>
                </div>
            @endforeach
            
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>