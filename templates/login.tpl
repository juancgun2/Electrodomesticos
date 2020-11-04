{include file="header.tpl"}
<div class="container">
  {if $error !== ""} 
    <div class="p-3 mb-2 bg-danger text-white">
      <svg width="2em" height="2em" viewBox="0 0 16 16" class="bi bi-exclamation-diamond" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
      <path fill-rule="evenodd" d="M6.95.435c.58-.58 1.52-.58 2.1 0l6.515 6.516c.58.58.58 1.519 0 2.098L9.05 15.565c-.58.58-1.519.58-2.098 0L.435 9.05a1.482 1.482 0 0 1 0-2.098L6.95.435zm1.4.7a.495.495 0 0 0-.7 0L1.134 7.65a.495.495 0 0 0 0 .7l6.516 6.516a.495.495 0 0 0 .7 0l6.516-6.516a.495.495 0 0 0 0-.7L8.35 1.134z"/>
      <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z"/>
      </svg> {$error}
    </div> 
  {/if}
  <div class="row"> 
    <div class="col"> 
      <h1> Inicia Sesion </h1>
      <div class="myBorder">
        <form class="px-4 py-3" action="iniciarSesion" method="POST">
            <div class="form-group">
                <label for="exampleDropdownFormEmail1">Email address</label>
                <input type="email" name="email" class="form-control" id="exampleDropdownFormEmail1" placeholder="email@example.com">
            </div>
            <div class="form-group">
                <label for="exampleDropdownFormPassword1">Password</label>
                <input type="password" name="password" class="form-control" id="exampleDropdownFormPassword1" placeholder="Password">
            </div>
            <button type="submit" class="btn btn-primary">Sign in</button>
        </form> 
      </div>
    </div> 
    <div class="col">
        <h1> Crea una Cuenta </h1> 
      <div class="myBorder">  
        <form class="px-4 py-3" action="registrarse" method="POST">
            <div class="form-group">
                <label for="exampleDropdownFormEmail1">Email address</label>
                <input type="email" name="newEmail" class="form-control" id="exampleDropdownFormEmail1" placeholder="email@example.com">
            </div>
            <div class="form-group">
                <label for="exampleDropdownFormPassword1">Password</label>
                <input type="password" name="newPassword" class="form-control" id="exampleDropdownFormPassword1" placeholder="Password">
            </div>
            <button type="submit" class="btn btn-primary">New Account</button>
        </form> 
      </div>
    </div>
  </div>
</div>
{include file="footer.tpl"}