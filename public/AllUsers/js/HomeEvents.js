// function AngleChange(e) {
//     let transform = e.target.style.transform; // Get the transform property
//     let rotateMatch = transform.match(/rotate\((-?\d+\.?\d*)deg\)/); // Use regex to extract the rotation value
    
//     if (rotateMatch) {
//         let rotateValue = parseFloat(rotateMatch[1]); // Extract and parse the angle value
//         console.log("Rotate Value:", rotateValue);
//     } else {
//         console.log("No rotation applied");
//     }
// }