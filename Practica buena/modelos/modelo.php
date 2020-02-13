<?php

/**
 *   Clase 'modelo' que implementa el modelo de nuestra aplicación en una
 * arquitectura MVC. Se encarga de gestionar el acceso a la base de datos
 * en una capa especializada
 */
class modelo {

  //Atributo que contendrá la referencia a la base de datos 
  private $conexion;
  // Parámetros de conexión a la base de datos 
  private $host = "localhost";
  private $user = "root";
  private $pass = "";
  private $db = "practica_php";

  /**
   * Constructor de la clase que ejecutará directamente el método 'conectar()'
   */
  public function __construct() {
    $this->conectar();
  }

  /**
   * Método que realiza la conexión a la base de datos de usuarios mediante PDO.
   * Devuelve TRUE si se realizó correctamente y FALSE en caso contrario.
   * @return boolean
   */
  public function conectar() {
    try {
      $this->conexion = new PDO("mysql:host=$this->host;dbname=$this->db;charset=utf8", $this->user, $this->pass);
      $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      return TRUE;

    } catch (PDOException $ex) {
      return $ex->getMessage();
    }
  }

  /**
   * Función que nos permite conocer si estamos conectados o no a la base de datos.
   * Devuelve TRUE si se realizó correctamente y FALSE en caso contrario.
   * @return boolean
   */
  public function estaConectado() {
    if ($this->conexion) :
      return TRUE;
    else :
      return FALSE;
    endif;
  }

  

  public function logear($nombre,$contraseña){

        /**$dt = new DateTime();
         * 'fecha' => $dt->format('Y-m-d H:i:s'), esto lo agrego al execute para poner la fecha de ingreso
         */
    //Realizamos la consulta...
    try {  //Definimos la instrucción SQL  
      $sql = "SELECT * FROM usuarios WHERE usuario =:nombre AND pass =:contrasena";
      // Hacemos directamente la consulta al no tener parámetros
      $resultsquery = $this->conexion->prepare($sql);

      $resultsquery->execute([
        'nombre'=>$nombre,
        'contrasena'=>$contraseña
        ]);

      //Supervisamos si la inserción se realizó correctamente... 
        $return['resultado']="correcto";
        $return['datos'] = $resultsquery->fetch(PDO::FETCH_ASSOC);
  
       // o no :(
    } catch (PDOException $ex) {
      $return = $ex->getMessage();
    }

    return $return;
}

public function crear($datos){
      
    //Realizamos la consulta...
    try {

    
      $sql = "INSERT INTO usuarios(usuario, pass, email, rol, departamento)
              VALUES(:nombre, :pass, :email,'profesor', :departamento)";

      $resultsquery = $this->conexion->prepare($sql);

      $resultsquery->execute([
        'nombre' => $datos['nombre'],
        'pass' => $datos['contraseña'],
        'email' => $datos['email'],
        'departamento' => $datos['departamento']
      ]);

      

      
    } catch (PDOException $ex) {
  $return = $ex->getMessage();
}

}

public function listarIncidenciasAdmin($inicio,$regsxpag){


    //Realizamos la consulta...
    try { $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM incidencias LIMIT $inicio, $regsxpag";
      // Hacemos directamente la consulta al no tener parámetros
      $stmt = $this->conexion->query($sql);
  
      // Para saber el número de páginas que hay
      $totalRegistros = $this->conexion->query("SELECT FOUND_ROWS() as total");
      $totalRegistros = $totalRegistros->fetch()["total"];
  
      $numeroPaginas = ceil($totalRegistros / $regsxpag);
      //Supervisamos si la inserción se realizó correctamente... 
      $return['resultado'] = "correcto";
      $return['datos'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
      $return["datosPaginacion"] = $numeroPaginas;
       //Definimos la instrucción SQL  
      /* $sql = "SELECT * FROM incidencias";
      // Hacemos directamente la consulta al no tener parámetros
      $resultsquery = $this->conexion->prepare($sql);

      $resultsquery->execute();

      //Supervisamos si la inserción se realizó correctamente... 
        $return['resultado']="correcto";
        $return['datos'] = $resultsquery->fetchAll(PDO::FETCH_ASSOC);
  
       // o no :( */
    } catch (PDOException $ex) {
      $return = $ex->getMessage();
    }

    return $return;
}

public function listarIncidenciasProf($usuario,$inicio,$regsxpag){

  try {  //Definimos la instrucción SQL  
    $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM incidencias WHERE usuario = :user LIMIT $inicio, $regsxpag ";
    // Hacemos directamente la consulta al no tener parámetros
    $stmt = $this->conexion->prepare($sql);

    // Para saber el número de páginas que hay
    
    $stmt->execute([
      'user' => $usuario
    ]);

    $totalRegistros = $this->conexion->query("SELECT FOUND_ROWS() as total");
    $totalRegistros = $totalRegistros->fetch()["total"];

    $numeroPaginas = ceil($totalRegistros / $regsxpag);
    //Supervisamos si la inserción se realizó correctamente... 
    $return['resultado'] = "correcto";
    $return['datos'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $return["datosPaginacion"] = $numeroPaginas;
  //Realizamos la consulta...
  /* try {  //Definimos la instrucción SQL  
    $sql = "SELECT * FROM incidencias WHERE usuario =:usuario";
    // Hacemos directamente la consulta al no tener parámetros
    $resultsquery = $this->conexion->prepare($sql);

    $resultsquery->execute([
      'usuario' => $usuario
    ]);

    //Supervisamos si la inserción se realizó correctamente... 
      $return['resultado']="correcto";
      $return['datos'] = $resultsquery->fetchAll(PDO::FETCH_ASSOC);

     // o no :( */
  } catch (PDOException $ex) {
    $return = $ex->getMessage();
  }

  return $return;
}

public function eliminarIncidenciasAdmin($id){
    try {  //Definimos la instrucción SQL  
      $sql = "DELETE FROM incidencias WHERE id =:id";
      // Hacemos directamente la consulta al no tener parámetros
      $resultsquery = $this->conexion->prepare($sql);
      $resultsquery->execute([
        'id'=>$id
        ]);

      //Supervisamos si la inserción se realizó correctamente... 
    if($resultsquery){
      return true;
    }else{
      return false;
    }

  
       // o no :(
    } catch (PDOException $ex) {
      $return = $ex->getMessage();
    }
}

public function agregarIncidencias($datos){
  $dt = new DateTime();
  $fecha = $dt->format('Y-m-d H:i:s');
  try {  //Definimos la instrucción SQL  
    $sql = "INSERT INTO `incidencias`(`usuario`, `departamento`, `incidencia`, `descripcion`, `fecha`) VALUES (:usuario,:departamento,:incidencia,:descripcion,:fecha)";
    // Hacemos directamente la consulta al no tener parámetros
    $resultsquery = $this->conexion->prepare($sql);
    $resultsquery->execute([
      'usuario'=>$datos['usuario'],
      'departamento' => $datos['departamento'],
      'incidencia'=>$datos['incidencia'],
      'descripcion'=>$datos['descripcion'],
      'fecha'=>$fecha
      ]);

    //Supervisamos si la inserción se realizó correctamente... 
  if($resultsquery){
    return true;
  }else{
    return false;
  }


     // o no :(
  } catch (PDOException $ex) {
    $return = $ex->getMessage();
  }
}

public function listarUsuarios(){


  //Realizamos la consulta...
  try {  //Definimos la instrucción SQL  
    $sql = "SELECT * FROM usuarios";
    // Hacemos directamente la consulta al no tener parámetros
    $resultsquery = $this->conexion->prepare($sql);

    $resultsquery->execute();

    //Supervisamos si la inserción se realizó correctamente... 
      $return['resultado']="correcto";
      $return['datos'] = $resultsquery->fetchAll(PDO::FETCH_ASSOC);

     // o no :(
  } catch (PDOException $ex) {
    $return = $ex->getMessage();
  }

  return $return;
}

public function hacerAdmin($id){
  try {  
    $sql  = "UPDATE usuarios SET rol='admin' WHERE `id`=:id";

    $resultsquery = $this->conexion->prepare($sql);
    $resultsquery->execute([
          'id'=>$id
      ]);


  if($resultsquery){
    $return= true;
  }else{
    $return= false;
  }
     // o no :(
  } catch (PDOException $ex) {
    $return = $ex->getMessage();
  }
  return $return; 

}



}
  