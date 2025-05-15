// gsap.registerPlugin(ScrollTrigger)
// let CategoryParentTag; 
// let CatgoryNamesGetId;
// let HWGetDiv;
// let HWGetId;
// let TimeSet=gsap.timeline()
// TimeSet.to(".animateOneByOne1",{y:0,duration:0.7,opacity:1})

// TimeSet.to(".animateOneByOne2",{y:0,duration:0.7,opacity:1})
// TimeSet.to(".animateOneByOne3",{y:0,duration:0.7,opacity:1})
// TimeSet.to(".animateOneByOne4",{y:0,duration:0.7,opacity:1})

// // // animate the products image and detail
// let imgAni=gsap.to(".imgDivAnimate",{
//     ease:Power2.easeInOut,
//     opacity:1,
//     duration:2,
//     stagger:7,
//     repeat:-1,
//     repeatDelay: 7,
//     scrollTrigger:{
//         trigger:".imgDivAnimate"
//     }
// })
// let textAni=gsap.to(".Detail",{
//     ease:Power2.easeInOut,
//     opacity:1,
//     duration:2,
//     stagger: 7,
//     repeat:-1,
//     repeatDelay: 7,
//     scrollTrigger:{
//         trigger:".Detail"
//     }
// })

// // apply animation on all the products 
// // let ChildsRow=document.getElementsByClassName("CategoryChilds");
// // for(let i=0;i<ChildsRow.length;i++){
// //     CategoryParentTag=ChildsRow[i].children;
// //     for(let tagS=0;tagS<CategoryParentTag.length;tagS++){
// //         let id=CategoryParentTag[tagS].firstElementChild.id;
// //         gsap.to(("#"+id), {
// //             scrollTrigger: {
// //                 trigger: "#" + id, // Element that triggers the animation
                
// //             },
// //             ease: "expo.inOut", 
// //             y: "0%",
// //             duration: 2,
// //             opacity:1,
// //         });
// //     }
// // }




// // animate the all categories that shw in circle 
// CatgoryNamesGetId=document.getElementById("HWCate").children;
// for(let c=0;c<=CatgoryNamesGetId.length;c++){
//     HWGetDiv=CatgoryNamesGetId[c];
//     HWGetId=HWGetDiv.firstElementChild.id;
    
//     console.log(HWGetId);
//     gsap.to("#"+HWGetId,{
//         y:0,
//         duration:2,
//         opacity:1,
//         scrollTrigger:{
//             trigger:"#"+HWGetId
//         }
//     })
// }


