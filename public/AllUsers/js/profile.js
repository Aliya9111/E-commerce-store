console.log('hello')

let ProfileList= event =>{
    let btnId=event.target;
    let IdNo=btnId.id.split('-').pop();
    let divId=document.getElementById('block-'+IdNo);
    let blocks=['block-1','block-2','block-3','block-4'];
    let btns=['btn-1','btn-2','btn-3','btn-4'];
    blocks.splice(blocks.indexOf('block-'+IdNo),1);
    btns.splice(btns.indexOf('btn-'+IdNo),1);

    // hide all div tags
    blocks.forEach(bId => {
        let bTidTg=document.getElementById(bId);
        if(bTidTg.classList.contains('d-block')){
            bTidTg.classList.remove('d-block')
            bTidTg.classList.add('d-none')
        }
    });

      // remove brder bottom
      btns.forEach(btnId => {
        document.getElementById(btnId).style.borderBottom="none";
    
    });
    if(divId.classList.contains('d-none')){
        divId.classList.remove('d-none');
        divId.classList.add('d-block');
    }
    btnId.style.borderBottom="1px solid rgb(119, 133, 207)";

}