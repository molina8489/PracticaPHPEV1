<?php include 'includes/barraProf.php'?>


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
    </style>
</head>

<body>
    <br><br><br>
        <table class="table table-dark">
            <tr>
                <th>Usuario</th>
                <th>Departamento</th>
                <th>Incidencia</th>
                <th>Descripción</th>
                <th>Fecha</th>
                <th></th>
            </tr>
            <?php foreach ($datos as $dato) {
                            ?> 
                        <tr>
                            <td><?= $dato["usuario"]; ?></td>
                            <td><?= $dato["departamento"]; ?></td>
                            <td><?= $dato["incidencia"]; ?></td>
                            <td><?= $dato["descripcion"]; ?></td>
                            <td><?= $dato["fecha"]; ?></td>
                            <td><button><a href="index.php?accion=eliminarIncidenciasAdmin&id=<?=$dato['id'] ?>">Eliminar</a></button></td>

                            </tr>   
                            <?php } ?> 

            
        </table>

        <button><a href="index.php?accion=Incidencias">Añadir Incidencia</a></button>
        <button><a href="index.php?accion=generarPDFProf">Generar PDF</a></button>
        <!-- futftrytruytruytruytr -->
        <div class="d-flex justify-content-center">

<ul class="pagination">
  <?php if ($pagina == 1) : ?>
    <li class="page-item disabled paginacion"><a class="page-link">&laquo;</a></li>
  <?php else : ?>
    <li class="page-item active paginacion"><a class="page-link" href="index.php?accion=listarIncidenciasAdmin&pagina=<?php echo $pagina - 1 ?>">&laquo;</a></li>
  <?php endif; ?>

  <?php
  $numeroPaginas = $incidencias["datosPaginacion"];
  for ($i = 1; $i <= $numeroPaginas; $i++) {
    if ($pagina == $i) {
      echo "<li class='page-item paginacion'><a class='page-link' href='index.php?accion=listarIncidenciasAdmin&pagina=$i'>$i</a></li>";
    } else {
      echo "<li class='active page-item paginacion'><a class='page-link' href='index.php?accion=listarIncidenciasAdmin&pagina=$i'>$i</a></li>";
    }
  }
  ?>

  <?php if ($pagina == $numeroPaginas) : ?>
    <li class="page-item disabled paginacion"><a class="page-link">&raquo;</a></li>
  <?php else : ?>
    <li class="page-item active paginacion"><a class="page-link" href="index.php?accion=listarIncidenciasAdmin&pagina=<?php echo $pagina + 1 ?>">&raquo;</a></li>
  <?php endif; ?>

</ul>
</div>
</body>
</html>