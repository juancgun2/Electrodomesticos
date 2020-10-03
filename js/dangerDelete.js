document.addEventListener("DOMContentLoaded",cargarPagina); 

function cargarPagina(){ 
    let elements=document.getElementsByClassName("btn dangerDelete"); 
    for (let i = 0; i < elements.length; i++) {
        elements[i].addEventListener("click",confirmacion);
    } 

    function confirmacion(){ 
        alert("Se eliminaran todos los productos que contengan esa categoria");
    } 
}