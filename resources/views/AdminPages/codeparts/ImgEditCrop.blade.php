<div class="modal fade" id="staticBackdrop1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="card border-0">
                    <div class="position-relative text-center divImgIncrease overflow-hidden" id="showedit">
                        <img class="img-fluid object-fit-contain mx-auto " id="showImg" style="transform:rotate(0deg);">
                        <div class="position-absolute bg-info " id="imgedit">
                            <a class="btn border-0 text-light w-100" id="bg-change">Edit</a>
                        </div>
                    </div>
                    {{--  show the rotate and crop button after click on edit button --}}
                    <div class="mt-3 d-none d-flex justify-content-center align-items-center" id="crop-rotate">
                        <div class="addRemove-space">
                            <a class="btn btn-dark" id="rotate-img"><i class="fa-solid fa-rotate"></i></a>
                            <a class="btn btn-dark " id="crop-img"><i class="fa-solid fa-crop"></i></a>
                        </div>
                        <a class="fs-3" id="check" onclick=SaveCropRotate()><i class="fa-solid fa-check"></i></a>
                    </div>

                    {{--  show the images in diiferent 4 angles after click on rotate icon button --}}
                    <div class="row text-center mt-3 d-none justify-content-center g-2" id="img-sides">
                        {{--  show image on top  --}}
                        <div class="col-md-2 col-3 overflow-hidden" id="img-top-hide">
                            <img id="img-top" class="object-fit-cover img-fluid full-size border border-2 border-primary" style="transform:rotate(0deg)" data-angel="0" onclick=imgDirection(event)>
                            <p class="text-light m-0 bg-dark position-relative">Top <i class="fa-solid fa-arrow-up text-primary"></i></p>
                        </div>
                        {{--  show image on left  --}}
                        <div class="col-md-2 col-3 overflow-hidden" id="img-left-hide">
                            <img id="img-left" class="object-fit-contain img-fluid" style="transform:rotate(-90deg);width:100%;" data-angel="-90" onclick=imgDirection(event)>
                            <p class="text-light m-0 bg-dark position-relative">left <i class="fa-solid fa-arrow-left text-primary"></i></p>
                        </div>
                        {{--  show image on right  --}}
                        <div class="col-md-2 col-3 overflow-hidden" id="img-right-hide">
                            <img id="img-right" class="object-fit-cover img-fluid" style="transform:rotate(90deg);" data-angel="90" onclick=imgDirection(event) >
                            <p class="text-light m-0 bg-dark position-relative">right <i class="fa-solid fa-arrow-right text-primary"></i></p>
                        </div>
                        {{--  show image on bottom  --}}
                        <div class="col-md-2 col-3 overflow-hidden" id="img-bottom-hide">
                            <img id="img-bottom" class="object-fit-cover img-fluid" style="transform:rotate(180deg)" data-angel="180" onclick=imgDirection(event)>
                            <p class="text-light m-0 bg-dark position-relative">bottom <i class="fa-solid fa-arrow-down text-primary"></i></p>
                        </div>
                    </div>
                    <div class="card-body info-font text-center" id="img-update">
                        <a class="btn btn-danger" onclick=deleteImg()>Delete</a>
                        {{--  take photo from camera  --}}
                        {{-- when click on button open the camera  --}}
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdropWebcam" onclick=TakePhoto()>
                          Take photo
                        </button>
                       
                    </div>
                </div>
            </div>
            <div class="modal-footer setButtonSize">
                <div class="row">
                    <div class="col-6">
                        <input type="hidden" name="rotation-angel2" value="rotate(0deg)" id="angel-set2">
                        <input type="file" class="btn btn-primary form-control" id="imguploadnew" name="file2" accept="image/*" onchange=newImg(event)>
                    </div>
                    <div class="col-6 text-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick=SaveImg()>Save</button>
                        <button type="button" class="btn btn-secondary topMargin" data-bs-dismiss="modal" onclick=CancelImg()>Close</button>
                    </div>
                </div>
               
            </div>
        </div>
    </div>
</div>
{{--  Open camera model   --}}
<div class="modal fade" id="staticBackdropWebcam" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabelWebcam" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" >
        <div class="modal-content" style="height:550px">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabelWebcam">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <div class="w-100" style="height: 387px;" id="take-photo"></div>
                <button type="button" class="btn btn-success mt-0 btn-lg" onclick=take_snapshot() data-bs-target="staticBackdrop1">Click</button>

            </div>
            <div class="modal-footer bg-light" >
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>



