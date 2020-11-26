
let vueComentarios = new Vue({
    el: "#vueComentarios", 
    data:{ 
        comentarios: [],
        rol: document.querySelector("#rol").value,
        promedioValoracion: 0, 
        cantidadPorEstrellas: []
    }, 
    methods: { 
        eliminar: function (id) {
            eliminarComentario(id);
        }, 
        estrellas: function(cantidad){ 
            let arreglo= [];
            for (let index = 0; index < cantidad; index++) {
                arreglo[index]=index+1;
            }
            return arreglo;
        }
    } 
})
  
document.addEventListener("DOMContentLoaded",function(){
    getByProducto();
    if(vueComentarios.rol === "admin" || vueComentarios.rol === "user"){
        document.querySelector("#submitComentario").addEventListener("click", e=> { 
            e.preventDefault();
            agregarComentario();
            });
        }
});

function getComentarios(){
    fetch("/apiv1/comentarios")
        .then(response => Response.json())
        .then(comentarios => vueComentarios.comentarios=comentarios)
        .catch(error => console.log(error));
}

function generarJSON(){ 
    let idProducto = document.querySelector("#idProducto").innerHTML;
    let puntuacion = document.querySelector("#newPuntuacion").value;
    let idUser = document.querySelector('#formIdUser').value;
    let descripcion = document.querySelector("#newDescripcion").value;
    idProducto = parseInt(idProducto);
    puntuacion = parseInt(puntuacion);
    idUser = parseInt(idUser);
    let comentario = {
        "usuario": idUser,
        "descripcion": descripcion,
        "puntuacion": puntuacion,
        "idProducto": idProducto
    };
    return comentario;
}

function agregarComentario(){
    let comentario = generarJSON();
    fetch("apiv1/comentarios", { 
        "method":"post", 
        "headers": {"Content-Type":"application/json"}, 
        "body": JSON.stringify(comentario)
    }).then(r => { 
        if(r.ok)
            return r.json(); 
        else 
            error("No se pudo agregar el comentario");
    }).then( comentario => {
                vueComentarios.comentarios.push(comentario); 
                vueComentarios.promedioValoracion = getPromedioValoracion(vueComentarios.comentarios);
                setCantidadEstrellas();
                document.querySelector("#newPuntuacion").value=1;
                document.querySelector("#newDescripcion").value="";
                hideError();
    }).catch( () => {
        error("No se pudo agregar el comentario");
    });
}

function getByProducto(){
    let id = document.querySelector("#idProducto").innerHTML;
    id = parseInt(id);
    fetch("apiv1/comentarios/" + id)
        .then(r => r.json()) 
        .then(comentariosProd => { 
                 vueComentarios.comentarios = comentariosProd; 
                 vueComentarios.promedioValoracion = getPromedioValoracion(comentariosProd); 
                 setCantidadEstrellas();
                 hideError();
                })
                .catch( () => error("No se pudo obtener los comentarios"));
}

function eliminarComentario(id){
    fetch("apiv1/comentarios/" + id, {
        "method":"delete", 
    })
    .then(r => { 
        if(r.ok) {
            vueComentarios.comentarios.forEach(element => {
                if(element.idComentario===id){ 
                    vueComentarios.comentarios.splice(vueComentarios.comentarios.indexOf(element),1);
                }
                vueComentarios.promedioValoracion = getPromedioValoracion(vueComentarios.comentarios);
                setCantidadEstrellas();
                hideError();
            })
        } else {
            error("No se pudo eliminar el comentario");;
        }
    }).catch( error("No se pudo eliminar el comentario"));
}

function getPromedioValoracion(comentarios){ 
    if(comentarios.length == 0)
        return 0;
    let suma=0;
    comentarios.forEach(element => {
        suma += parseInt(element.puntuacion);
    }) 
    const promedio = suma/comentarios.length; 
    return parseInt(promedio);
}

/**
 * Dado un valor entre 1 y 5 cuenta la cantidad de veces que se valoro el producto con ese valor
 * @param {*} numeroEstrellas 
 */
function cantidadEstrellas(numeroEstrellas){ 
    let cantidad = 0;
    console.log(numeroEstrellas);
    vueComentarios.comentarios.forEach( e => { 
        console.log(e.puntuacion);
        if(e.puntuacion == numeroEstrellas){ 
            cantidad = cantidad + 1;
        }
    });
    return cantidad;
}

function setCantidadEstrellas(){ 
    vueComentarios.cantidadPorEstrellas=[];
    for (let i = 0; i < 5; i++) {
        let json = { 
            estrellas: i+1, 
            cantidad: cantidadEstrellas(i+1)
        };
        vueComentarios.cantidadPorEstrellas.push(json);
    }
}

function showError(error) { 
    document.querySelector("#errorComentario").innerHTML = error; 
    if(document.querySelector("#containerErrorComentario").classList.contains("dontShow")){
        document.querySelector("#containerErrorComentario").classList.toggle("dontShow");
    }
    return false;
}

function hideError(){
    if(!document.querySelector("#containerErrorComentario").classList.contains("dontShow")){
        document.querySelector("#containerErrorComentario").classList.toggle("dontShow");
    }
}

