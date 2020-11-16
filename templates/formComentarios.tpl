
<h4> Agregar Comentario </h4>
<div class="col-md-10">
    <form action="" method="">
        <input type="hidden" class="form-control" id="formIdUser" value="{$idUsuario}">
        <div class="form-group">
            <label>Descripcion</label>
            <textarea class="form-control" id="newDescripcion" rows="3"></textarea>
        </div>
        <div class="form-group">
            <label>Puntuacion</label>
            <select class="form-control" id="newPuntuacion">
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
            </select>
        </div>
        <button type="submit" id="submitComentario" class="btn btn-primary">Submit</button>
    </form> 
</div>