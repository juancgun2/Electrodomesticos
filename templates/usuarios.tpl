{include file="header.tpl"}
<table class='table table-hover table-dark'>
    <thead>
        <tr>
            <th scope='col'>Email</th>
            <th scope='col'>Rol</th>
            <th scope='col'>Establecer como</th>
            <th scope='col'>Eliminar</th>
        </tr>
    </thead>
    <tbody>
    {foreach from=$usuarios item=usuario} 
        {if $usuario->email != $email}
            <tr>
                <th scope='col'>{$usuario->email|capitalize}</th>
                <td>{$usuario->permisos|capitalize}</td> 
                {if $usuario->permisos === "admin"}
                    <td><button class='btn' type='button'><a class='btn btn-secondary btn-lg active'
                        href="setUsuario/{$usuario->id_login}">Usuario</a></button>
                    </td>
                {else}
                    <td><button class='btn' type='button'><a class='btn btn-secondary btn-lg active'
                        href="setAdmin/{$usuario->id_login}">Admin</a></button>
                    </td>
                {/if}
                <td><button class='btn' type='button'><a class='btn btn-secondary btn-lg active'
                    href="eliminarUsuario/{$usuario->id_login}">Eliminar</a></button>
                </td>
            </tr>
        {else} 
            <tr>
                <th scope='col'>{$usuario->email|capitalize}</th>
                <td>{$usuario->permisos|capitalize}</td> 
                <td> - </td> 
                <td> - </td>
            </tr>
        {/if}
    {/foreach}
    <tbody>
{include file="footer.tpl"}