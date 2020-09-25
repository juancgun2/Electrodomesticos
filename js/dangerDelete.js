document.addEventListener("DOMContentLoaded",cargarPagina); 

function cargarPagina(){ 
    let elements=document.getElementsByClassName("btn dangerDelete"); 
    for (let i = 0; i < elements.length; i++) {
        elements[i].addEventListener("click",showConfirm);
    } 


    function showConfirm(){ 
         if(!confirm()){ 
            //debo cancelar la eliminacion
         }
    }


    function confirm(){ 
        confirm("Se eliminaran todos los productos que contengan esa categoria");
    }
}