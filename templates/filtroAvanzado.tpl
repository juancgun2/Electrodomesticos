<div class="bg-secondary"> 
    <form class="wrapper p-1 pt-2" action="filtrados" method="POST">
        <div class="form-row mr-2">
            <div class="col">
                <label class="font-weight-bold text-warning">PRECIO MINIMO</label>
                    <select name="filtro_precioMinimo" class="form-control">
                        <option> 0 </option>
                        <option> 500 </option>
                        <option> 1000 </option>
                        <option> 10000 </option>
                        <option> 100000 </option>
                    </select>
            </div>
        </div>
        <div class="form-row mr-2">
            <div class="col">
                <label class="font-weight-bold text-warning">PRECIO MAXIMO</label>
                    <select name="filtro_precioMaximo" class="form-control">
                        <option> 500 </option>
                        <option> 1000 </option>
                        <option> 10000 </option>
                        <option> 100000 </option>
                        <option> 500000 </option>
                    </select>
            </div>
        </div>
        <div class="form-row p-1 align-self-end ml-3">
            <button type="submit" class="btn btn-sm btn-dark">APLICAR</button>
        </div>
    </form>
</div>