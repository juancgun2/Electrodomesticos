<div class="container-fluid d-inline-flex justify-content-center bg-warning"> 
    <form class="container d-inline-flex justify-content-center p-1 mt-2" action="home/filtrados" method="POST">
        <div class="form-row mr-2">
            <div class="col">
                <label class="font-weight-bold">NOMBRE</label>
                <input type="text" class="form-control" name="filtro_producto">
            </div>
        </div>
        <div class="form-row mr-2">
            <div class="col">
                <label class="font-weight-bold">CATEGORIA</label>
                    <select name="filtro_categoria" class="form-control">
                        <option selected></option>
                        {foreach from=$categorias item=categoria}
                            <option>{$categoria->name}</option>
                        {/foreach}
                    </select>
            </div>
        </div>
        <div class="form-row mr-2">
            <div class="col">
                <label class="font-weight-bold">PRECIO MINIMO</label>
                    <select name="filtro_precioMinimo" class="form-control">
                        <option>0</option>
                        <option>$500</option>
                        <option>$1.000</option>
                        <option>$10.000</option>
                        <option>$100.000</option>
                    </select>
            </div>
        </div>
        <div class="form-row mr-2">
            <div class="col">
                <label class="font-weight-bold">PRECIO MAXIMO</label>
                    <select name="filtro_precioMaximo" class="form-control">
                        <option>$500</option>
                        <option>$1.000</option>
                        <option>$10.000</option>
                        <option>$100.000</option>
                        <option>$500.000</option>
                    </select>
            </div>
        </div>
        <div class="form-row p-1 align-self-end ml-3">
            <button type="submit" class="btn btn-sm btn-secondary">APLICAR</button>
        </div>
    </form>
</div>