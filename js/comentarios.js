
let vueComentarios = new Vue({
    el: "#vueComentarios", 
    data:{ 
        comentarios: [],
        rol: document.querySelector("#rol").value
    }, 
    methods: { 
        eliminar: function (id) {
            eliminarComentario(id);
        }, 
        estrellas: function(puntuacion){ 
            let arreglo= [];
            for (let index = 0; index < puntuacion; index++) {
                arreglo[index]=index+1;
            }
            return arreglo;
        }
    } 
})
  
document.addEventListener("DOMContentLoaded",function(){
    getByProducto();

    document.querySelector("#submitComentario").addEventListener("click", e=> { 
        e.preventDefault();
        agregarComentario();
        });
});

function getComentarios(){
    fetch("/mermelada/comentarios")
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
    fetch("mermelada/comentarios", { 
        "method":"post", 
        "headers": {"Content-Type":"application/json"}, 
        "body": JSON.stringify(comentario)
    }).then(r => r.json())
    .then(comentario => {
        vueComentarios.comentarios.push(comentario) 
        document.querySelector("#newPuntuacion").value=1;
        document.querySelector("#newDescripcion").value="";
    }).catch(error => console.log(error));
}

function getByProducto(){
    let id = document.querySelector("#idProducto").innerHTML;
    id = parseInt(id);
    fetch("mermelada/comentarios/" + id)
        .then(r => r.json()) 
        .then(comentariosProd => vueComentarios.comentarios=comentariosProd)
        .catch(error => console.log(error));
}

function eliminarComentario(id){
    fetch("mermelada/comentarios/" + id, {
        "method":"delete", 
    })
    .then(r => { if(r.ok) 
        vueComentarios.comentarios.forEach(element => {
            if(element.idComentario===id){ 
                vueComentarios.comentarios.splice(vueComentarios.comentarios.indexOf(element),1);
            }
    })
    }).catch(error => console.log(error));
}

