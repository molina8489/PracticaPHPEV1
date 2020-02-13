<?php include 'includes/barraAdmin.php'?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Usuarios</title>
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
    </style>
</head>

<body>
    <br><br><br>
        <table class="table table-dark">
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Departamento</th>
                <th></th>
            </tr>
            <?php foreach ($datos as $dato) { 
                            ?> 
                        <tr>
                            <td><?= $dato["id"]; ?></td>
                            <td><?= $dato["usuario"]; ?></td>
                            <td><?= $dato["email"]; ?></td>
                            <td><?= $dato["rol"]; ?></td>
                            <td><?= $dato["departamento"]; ?></td>
                            <td><?php if($dato["rol"]=="profesor"):?><button><a href="index.php?accion=hacerAdmin&id=<?= $dato['id'] ?>">Hacer Admin</a></button></td>
                              <?php endif;?>
                            </tr>   
                            <?php } ?> 

            
        </table>

        
</body>
</html>