<?php include 'includes/barraAdmin.php'?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Incidencias</title>
    <style>
    a{ color:white;
      font-size: 20px;}
      a:hover{
        text-decoration: none;
        color:grey;
      }
      button{
        color: #fff;
        background-color: #3f51b5;
        border:none;
      }
      p{
        color:#3f51b5;
      font-size: 30px;
      }
    </style>
</head>

<body>
    <br><br><br>
      <form action="index.php?accion=agregarIncidencias" method="post" id="formIncidencias">
          <p>Incidencia</p>
          <input type="text" name="incidencia">
          <p>Descripción</p>
          <textarea name="descripcion" cols="100" rows="3" form="formIncidencias"></textarea>
          <br><br>
          <button type="submit" name="agregarIncidencias">Aceptar</button>
          <button type="submit" name="entrar">Cancelar</button>
      </form>
</body>
</html>