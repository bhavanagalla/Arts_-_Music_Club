var iconImg; 
var pictures = ["r4","r5","r1","r2","r8","r10","r11","r12"];
var descriptions = ["Treble Clef","Quaver","Beam","sharp","Bass clef","crotchet","Minim","semi quaver"];

// pick a random image and corresponding description then modify
// the img element in the document's body 
function pickImage()
{
   var index = Math.floor( Math.random() * 8 );
   iconImg.setAttribute( "src", pictures[ index ] + ".png" );
   iconImg.setAttribute( "alt", descriptions[ index ] );
} // end function pickImage

// registers iconImg's click event handler
function start()
{
   iconImg = document.getElementById( "image" );
   iconImg.addEventListener( "click", pickImage, false );
} // end function start

window.addEventListener( "load", start, false );