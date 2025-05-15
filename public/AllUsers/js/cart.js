document.getElementById("hotSear").addEventListener('click',()=>{
    let shareTg=document.getElementsByClassName("share")[0];
    shareTg.classList.toggle('d-none')
})

function ShowRewDes(e){
    let desTag=document.getElementById("des");
    let ReviewsTag=document.getElementById("Reviews");
    let desDetailTag=document.getElementById("desDetail");
    let RevDetailTag=document.getElementById("RevDetail");

    let EventTag=e.target;
    console.log(EventTag)
    if(EventTag.id==desTag.id){
        console.log("description")
        desTag.style.borderBottom="2px solid rgb(119, 133, 207)";
        ReviewsTag.style.borderBottom="none";
        if(desDetailTag.classList.contains('d-none')){
            desDetailTag.classList.remove('d-none')
            desDetailTag.classList.add('d-inline')
        }
        if(RevDetailTag.classList.contains('d-inline')){
            RevDetailTag.classList.remove('d-inline')
            RevDetailTag.classList.add('d-none')
        }
    }
    else{
        desTag.style.borderBottom="none";
        ReviewsTag.style.borderBottom="2px solid rgb(119, 133, 207)";
        if(RevDetailTag.classList.contains('d-none')){
            RevDetailTag.classList.remove('d-none')
            RevDetailTag.classList.add('d-inline')

        }
        if(desDetailTag.classList.contains('d-inline')){
            desDetailTag.classList.remove('d-inline')
            desDetailTag.classList.add('d-none')

        }
    }
}