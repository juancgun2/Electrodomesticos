document.addEventListener("DOMContentLoaded",cargarPagina); 

function cargarPagina(){ 
    let elements=document.getElementsByClassName("btn dangerDelete"); 
    for (let i = 0; i < elements.length; i++) {
        elements[i].addEventListener("click",confirmacion);
    } 


    function showConfirm(){ 
         if(!confirm()){ 
            //debo cancelar la eliminacion
         }
    }


    function confirmacion(){ 
        confirm("Se eliminaran todos los productos que contengan esa categoria");
    } 
}