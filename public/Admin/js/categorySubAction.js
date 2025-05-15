let currentRotation = 0;
let cropper="";
let CopyCropper="";
function ShowImage(event){
    var file=event.target.files[0];
        let imgtag=document.getElementById("imgUpload");
        console.log(imgtag);
        imgtag.src=URL.createObjectURL(file);
        if(document.getElementById("imguploadnew").value!=""){
            document.getElementById("imguploadnew").value="";
        }
        if(document.getElementById("boxShow").classList.contains("d-none")){
            document.getElementById("boxShow").classList.remove("d-none");
            document.getElementById("boxShow").classList.add("d-inline");
        }

}
// show the new image after update
function newImg(event){
    let showNewImg=document.getElementById("showImg");
    var newfile=event.target.files[0];
    if(newfile){
        showNewImg.src=URL.createObjectURL(newfile);
    }
}
let hideUnhide=()=>{
    let editbtn=document.getElementById("imgedit");
    let cropRotate=document.getElementById("crop-rotate");
    let imgUpdate=document.getElementById("img-update");
    let imgSides=document.getElementById("img-sides");
    let newImg=document.getElementById("showImg");
    if(document.getElementById("check").classList.contains("check-effectAdd")){
        document.getElementById("check").classList.remove("check-effectAdd");
    }
    if(editbtn.classList.contains("d-none")){
        editbtn.firstElementChild.classList.add("bg-info");
        editbtn.classList.remove("d-none");
        editbtn.classList.add("d-block");

    }
    if(cropRotate.classList.contains("d-block")){
        cropRotate.classList.remove("d-block");
        cropRotate.classList.add("d-none");

    } if(imgUpdate.classList.contains("d-none")){
        imgUpdate.classList.remove("d-none");
        imgUpdate.classList.add("d-block");

    }
    if(imgSides.classList.contains("d-flex")){
        imgSides.classList.remove("d-flex");
        imgSides.classList.add("d-none");

    }
    if(document.getElementById("check").classList.contains("d-inline")){
        document.getElementById("check").classList.remove("d-inline")
        document.getElementById("check").classList.add("d-none")
    }
   
    if(cropper!="")
    {
        // Reset the cropper to show the unmodified image again
        cropper.destroy();
        cropper = null; // Clear the cropper instance
        cropper="";
    }
}
// save image after update
function SaveImg(){
    let oldImg=document.getElementById("imgUpload");
    let newImg=document.getElementById("showImg");
    let oldimgsrc=oldImg.src;
    let newimgsrc=newImg.src;
    console.log("src=" + newimgsrc);
    let oldImgInput= document.getElementById("emptyValue");
    // console.log("old image"+oldimgsrc);
    // console.log("new image"+newimgsrc);


    // if upload new image and then match the new and old if both are different run this condition
    if(newimgsrc==""){
        console.log("empty src");
        if(oldImgInput.value!="")  {oldImgInput.value="";}
        oldImg.src=document.getElementById("imgUploadhidden").src;
        oldImg.style.transform="rotate(0deg)";
        document.getElementById("angel-set1").value="rotate(0deg)";
    }
    else{
        if(oldimgsrc!=newimgsrc){
            console.log("error");
            if(CopyCropper==""){
                console.log("different images");
                newImgInput=document.getElementById("imguploadnew").files[0];
                console.log(document.getElementById("imguploadnew").files);

                // Create a new DataTransfer object to transfer the file
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(new File([newImgInput], newImgInput.name, { type: newImgInput.type }));
                // Assign the file(s) to the target input
                oldImgInput.files = dataTransfer.files;
                console.log(document.getElementById("emptyValue").files);

            }
            else{
                console.log("other part of different images");
                newImgInput=document.getElementById("showImg").src; 
                fetch(newImgInput)
                .then(response => response.blob())
                .then(blob => {
                    // Create a new File from the Blob
                    const file = new File([blob], "cropped-image.jpg", { type: blob.type });
                    
                    // Create a DataTransfer object to add the file
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);

                    // Assign the file to the target input
                    oldImgInput.files = dataTransfer.files;
                })
                .catch(error => console.error("Error converting image src to file:", error));
            }
            if(cropper==""){
                jQuery.noConflict();
                jQuery(document).ready(function($){
                    $("#imgUpload").attr("src",newimgsrc)
            });
            }
        };
        // set the angel of updated image in old image place
        let newImgAngel=newImg.style.transform;
        oldImg.style.transform=newImgAngel;
        // update the angel in of image in input field
        document.getElementById("angel-set1").value=newImgAngel;
        // let getCropper=document.getElementById("emptyValue").dataset.cropper;
        if(cropper!=""){
            
            console.log("crop unempty");
            cropImage(cropper);}

        // hide unhide the buttons of crop,edit, detelet ,take photo ,upload new, edit
        hideUnhide();
    }
} 
// if not save the changings so close the screen
function CancelImg(){
    if(document.getElementById("imguploadnew").value!=""){
        document.getElementById("imguploadnew").value="";
    }
    let oldImgAngelCancel=document.getElementById("imgUpload").style.transform;
    document.getElementById("showImg").style.transform=oldImgAngelCancel;
    // unhide again delete ,take photo, uplaod file
    hideUnhide();
}
function deleteImg(){
    console.log("before delete image"+document.getElementById("showImg").src);
    console.log(document.getElementById("showImg").attributes.length);
    // document.getElementById("showImg").src=null;
    document.getElementById("showImg").removeAttribute("src");

    console.log("After delete image"+document.getElementById("showImg").src);
    console.log(document.getElementById("showImg").attributes.length);

    if(document.getElementById("imguploadnew").value!=""){
        document.getElementById("imguploadnew").value="";
    }
}
// edit image
function EditImg(){
    let imgtag=document.getElementById("imgUpload");
    let setImg=document.getElementById("showImg");
    setImg.src=imgtag.src;
    setImg.style.transform=imgtag.style.transform;
}

// crop image
jQuery.noConflict();
jQuery(document).ready(function($){
    // crop the image
    $("#crop-img").click(function(){
        $("#crop-img").addClass('bg-info');
        $("#rotate-img").removeClass('bg-info');
        $("#img-sides").addClass("d-none");
        if(document.getElementById("check").classList.contains("check-effectRemove")){
            $("#check").removeClass("check-effectRemove");
        }
        $("#check").addClass("check-effectAdd");
        if(document.getElementById("check").classList.contains("d-none")){
            document.getElementById("check").classList.remove("d-none")
            document.getElementById("check").classList.add("d-inline")
        }

        // set the crooping area on image
        if (cropper) {
            cropper.destroy();
        }
        const ImgShow=document.getElementById("showImg");
        cropper = new Cropper(ImgShow, {
            aspectRatio: 12 / 9,
         
            crop(event) {
                currentRotation = event.detail.rotate;
            //   console.log(event.detail.x);
            //   console.log(event.detail.y);
            //   console.log(event.detail.width);
            //   console.log(event.detail.height);
            //   console.log(event.detail.rotate);
            //   console.log(event.detail.scaleX);
            //   console.log(event.detail.scaleY);
            },
        });
        // $("#angel-set3").attr("data-cropper",cropper);
        
    });
});
function cropImage(cropper){
    console.log("crop image");
    cropper.rotateTo(currentRotation);
    const croppedCanvas = cropper.getCroppedCanvas();
    // Display the cropped image in another div
    const croppedImageDisplay = document.getElementById("imgUpload");
    croppedImageDisplay.src = croppedCanvas.toDataURL(); // base64 string for the image

    // Convert the canvas to a Blob and set it in an input field for form submission
    croppedCanvas.toBlob((blob) => {
        const fileInput = document.getElementById("emptyValue");
        let newimgAngel=document.getElementById("showImg").style.transform;
        document.getElementById("angel-set1").value=newimgAngel;
        const file = new File([blob], "cropped-image.jpg", { type: "image/jpeg" });
        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(file);
        fileInput.files = dataTransfer.files;
    }, "image/jpeg");
      // Reset the cropper to show the unmodified image again
    //   cropper.destroy();
    //   cropper = null; // Clear the cropper instance
}
// images in different 4 angels and crop the image
jQuery.noConflict();
jQuery(document).ready(function($){
    // images in different 4 angels
    $("#rotate-img").click(function(){
        // $("#crop-rotate").children("i").addClass("bg-info");
        $("#rotate-img").addClass("bg-info");
        $("#crop-img").removeClass('bg-info');

        $("#img-sides").removeClass("d-none");
        $("#img-sides").addClass("d-flex");
        if(document.getElementById("check").classList.contains("check-effectAdd")){
            $("#check").removeClass("check-effectAdd");
        }
        $("#check").addClass("check-effectRemove");
        if(document.getElementById("check").classList.contains("d-inline")){
            document.getElementById("check").classList.remove("d-inline")
            document.getElementById("check").classList.add("d-none")
        }

        // get div tag and and images
        let divImg=document.getElementById("img-sides").children;
        for(let i=0;i<divImg.length;i++){
            divImg[i].children[0].src=$("#showImg").attr("src");
            // divImg[i].children[0].height="70px";
            // divImg[i].children[0].width="70px";

        }
        if(cropper!="")
            {
                // let getCroopedArea=cropper.getCroppedCanvas();
                // $("#showImg").attr("src",getCroopedArea.toDataURL());
                // Reset the cropper to show the unmodified image again
                cropper.destroy();
                cropper = null; // Clear the cropper instance
                cropper="";
            }
    });
});
// save the crop image in when click on check icon
function SaveCropRotate(){
    if(cropper!=""){
        let cropImgSave=document.getElementById("showImg");
        let croppedArea=cropper.getCroppedCanvas();
        cropImgSave.src=croppedArea.toDataURL();
        CopyCropper=cropper;
        cropper.destroy();
        cropper=null;
        cropper="";
    }
}

function TakePhoto(){
    // let PhotoTag=document.getElementById("take-photo");
    Webcam.set({
        width: 460,
        height: 387,
        image_format: 'jpeg',
        jpeg_quality: 90
       });	 
       Webcam.attach( '#take-photo' );
}
function take_snapshot() {
    // play sound effect
    //shutter.play();
    // take snapshot and get image data

    Webcam.snap( function(data_uri) {
    // console.log(data_uri);

    // display results in page
    document.getElementById('showImg').src=data_uri;
   
    });	
    console.log(document.getElementById('showImg')); 
    fetch( document.getElementById('showImg').src).then(response=>response.blob())
    .then(blob => {
        const WebFile=new File([blob],"webCamImg.jpeg",{type:blob.type});
        datatrans=new DataTransfer();
        datatrans.items.add(WebFile);
        console.log(document.getElementById("imguploadnew").files);

        document.getElementById("imguploadnew").files=datatrans.files;
        console.log(document.getElementById("imguploadnew").files);
    });
    Webcam.reset();
     // Close the current modal
     var currentModal = bootstrap.Modal.getInstance(document.getElementById('staticBackdropWebcam'));
     currentModal.hide();
 
     // Open the new modal
     var newModal = new bootstrap.Modal(document.getElementById('staticBackdrop1'));
     newModal.show();
   }
   // when click on edit button hide the edit,delete,upload new take photo and the unhide the crop and rotate button

document.getElementById("imgedit").addEventListener("click",function(){
    jQuery.noConflict();
    jQuery(document).ready(function($){
        $("#bg-change").css('backgroundColor','#afdce6');
        $("#crop-rotate").removeClass("d-none");
        $("#crop-rotate").addClass("d-block");
        $("#imgedit").addClass("d-none");
        $("#img-update").addClass("d-none");
        
    });
   
});

// change the direction of image
function imgDirection(e){
    let sides=["img-top","img-left","img-right","img-bottom"];
    let imgTag=e.target;
    let imgTagId=e.target.id;
    let imgTagValue=imgTag.dataset.angel;
    // add border on selected image
    imgTag.classList.add('border','border-2','border-primary');
    sides.splice(sides.indexOf(imgTagId),1);
    
    // romove the border unselected images
    sides.forEach(value=>{
        document.getElementById(value).classList.remove('border','border-2','border-primary');
    });
    document.getElementById("showImg").style.transform="rotate("+imgTagValue+"deg)";
}