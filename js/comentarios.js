
let vueComentarios = new Vue({
    el: "#vueComentarios", 
    data:{ 
        comentarios: [],
        rol: document.querySelector("#rol").value
    }, 
    methods: { 
        eliminar: function (id) {
            eliminarComentario(id);
        }
    }
})
  
document.addEventListener("DOMContentLoaded",function(){
    getByProducto();

    document.querySelector("#submitComentario").addEventListener("submit", e=> { 
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

function agregarComentario(){
    let idProducto =document.querySelector("#idProducto").innerHTML;
    idProducto= parseInt(idProducto);
    let puntuacion=document.querySelector("#newPuntuacion").value;
    puntuacion = parseInt(puntuacion);
    let comentario = {
        "usuario": document.querySelector('#formIdUser').value,
        "descripcion": document.querySelector("#newDescripcion").value,
        "puntuacion": puntuacion,
        "idProducto": idProducto
    };
    console.log(comentario);
    console.log(JSON.stringify(comentario));
    fetch("mermelada/comentarios",{ 
        "method":"post", 
        "headers": {"Content-Type":"application/json"}, 
        "body": JSON.stringify(comentario)
    }).then(r => r.json())
    .then(comentario => vueComentarios.comentarios.push(comentario))
        .catch(error => console.log(error));
}

function getByProducto(){
    let id =document.querySelector("#idProducto").innerHTML;
    id=parseInt(id);
    fetch("mermelada/comentarios/"+id)
        .then(r => r.json()) 
        .then(comentariosProd => vueComentarios.comentarios=comentariosProd)
        .catch(error => console.log(error));
}

function eliminarComentario(id){
    fetch("mermelada/comentarios/"+ id/*this.getAttribute("idComentario").value*/,{
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

