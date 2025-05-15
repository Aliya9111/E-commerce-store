function hideColumn(){
    document.querySelector('.OpenClose').classList.toggle('close');

    /*get all the tags whose class is .hidea and then add d-inline or d-none class when click on the bars button 
      hide all the columns in all rows and show the column that is unhide after didding all coulmns from all rows
    */
    let getchild=document.querySelectorAll(".hidea");
    for(let i=0; i<getchild.length; i++){
        let aTag=getchild[i];
        if(aTag.classList.contains('d-inline')){
            aTag.classList.remove("d-inline");
            aTag.classList.add("d-none");
        }
        else{
            aTag.classList.remove("d-none");
            aTag.classList.add("d-inline");
        }
    }
    let getFullSize=document.getElementById("fullsize");
    let getclasses=getFullSize.classList;
    console.log(getFullSize);
    if(getclasses.length==4){
        getFullSize.classList.remove("col-lg-10");
        getFullSize.classList.remove("col-md-9");
        getFullSize.classList.remove("col-sm-8");
        getFullSize.classList.add("col-sm-11");


    }
    else{
        getFullSize.classList.add("col-lg-10");
        getFullSize.classList.add("col-md-9");
        getFullSize.classList.add("col-sm-8");
        getFullSize.classList.remove("col-sm-11");
    }
}
// change the background color of nav bars
function ChangeColorClick(event){
    let rowTag=event.target;
    let getChilds=rowTag.parentNode.parentNode.children;
    for(let j=0;j<(getChilds.length)-1; j++){
        let getClasses=getChilds[j];
        if(!(getClasses.classList.contains("darklight"))){
              getClasses.classList.add("darklight");
              getClasses.classList.remove("bgblue");
        }
        else{
            getClasses.classList.remove("darklight");
            getClasses.classList.add("bgblue");

        }
    } 
}

