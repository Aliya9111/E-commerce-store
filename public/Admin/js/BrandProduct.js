
let addOptions= (subcategories,getTag)=>{
   for(let i=0; i<subcategories.length;i++){
        let setOptionTag=document.createElement('option');
        setOptionTag.value=subcategories[i]['id'];
        setOptionTag.innerText=subcategories[i]['sname'];
        getTag.appendChild(setOptionTag);
   }
};
// set the subcateogories of eact category
function SetSubcategories(event){
    let selectedOption = event.target.options[event.target.selectedIndex];
    
    // Get the category data from the 'data-category' attribute
    let categorydata = selectedOption.getAttribute('data-category');
    // convert string array into js array
    let category=JSON.parse(categorydata);
    let subcategories=category['subcategories'];
    let getTag=document.getElementById("DynamicSet");
    // check subcategories of category are present so create the options tag if not the else
    // part excecute if subcategories of previous categories are show so all the sucategories remove
    if(subcategories.length>0){
        // if the length of options tag are greater than 1 so fisrt remove the options tag and then appent the new options tags of subcategories 
        if(getTag.options.length>1){
            for(let j = getTag.options.length - 1; j > 0; j--){
                getTag.removeChild(getTag[j]);
            }
            addOptions(subcategories,getTag);
        }
        // add the options tags with new subcategories
        else{
            addOptions(subcategories,getTag);
        }
    }
    else{
        if(getTag.options.length>1){
            for(let j = getTag.options.length - 1; j > 0; j--){
                getTag.removeChild(getTag[j]);
            }
        }
    }
}
// delete the image from the uploaded
function deleteImage(imaggeId){
    let getTag=document.getElementById("image-row-"+imaggeId);
    getTag.remove();
    let errorTags=document.querySelectorAll(".removeList");
    if(errorTags.length==0){
        let btnTag=document.getElementById("btnSetDis");
        if(btnTag.hasAttribute("disabled")){
            btnTag.removeAttribute("disabled");
        }
    }
}