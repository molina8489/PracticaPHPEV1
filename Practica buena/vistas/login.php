<!DOCTYPE html>
<html lang="es" >
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="vistas/login.css">

</head>
<body>
<!-- partial:index.partial.html -->
<div class="login-page">
  <div class="form">
    <form class="register-form" method="post" action="index.php?accion=crear">
      <input type="text" name="nombre" placeholder="nombre"/>
      <input type="password" name="contraseña" placeholder="contraseña"/>
      <input type="text" name="email" placeholder="dirección email"/>
      <p>Departamento
      <select name="departamento">
        <option>Informática</option> 
        <option>Finanzas</option> 
        <option>Comercio</option>
      </select></p>
      <br>
      <button type="submit" name="crear">Crear</button>

      <p class="message">Registrado? <a href="#">Iniciar</a></p>
    </form>
    <form class="login-form" method="post" action="index.php?accion=logear">
      <input type="text" name="nombreentrar" placeholder="usuario"/>
      <input type="password" name="cntentrar" placeholder="contraseña"/>
      <button type="submit" name="entrar">Entrar</button>
      <p class="message">No registrado? <a href="#">Crear una cuenta</a></p>
    </form>
  </div>
</div>
<!-- partial -->
  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script><script  src="vistas/login.js"></script>

</body>
</html>