//console.log("tötöab!");

//muutujad
let fileSizeLimit = 1024 * 1024;


window.onload = function(){
    document.querySelector("#photo_submit").disabled = true;
    document.querySelector("#photo_input").addEventListener("change", checkSize); //kui fnc taga on sulud siis pannakse see ainult 1 korra.
}

function checkSize(){
    if(document.querySelector("#photo_input").files[0].size <= fileSizeLimit){
        document.querySelector("#photo_submit").disabled = false;
        //<span>-siia vaja tyhjuss saada-</span> ,seal kys seal tyhjus on .innerHTML
        document.querySelector("#notice").innerHTML = "";
    }else{
        document.querySelector("#photo_submit").disabled = true;
        document.querySelector("#notice").innerHTML = "Valitud fail on <strong>liiga suur</strong>!";
    }
}