<?php
        session_start();
/**
 * Incluimos el modelo para poder acceder a su clase y a los métodos que implementa
 */
require_once 'modelos/modelo.php';
require 'pdf/fpdf.php';

/**
 * Clase controlador que será la encargada de obtener, para cada tarea, los datos
 * necesarios de la base de datos, y posteriormente, tras su proceso de elaboración,
 * enviarlos a la vista para su visualización
 */
class controlador {

  // El el atributo $modelo es de la 'clase modelo' y será a través del que podremos 
  // acceder a los datos y las operaciones de la base de datos desde el controlador
  private $modelo;
  //$mensajes se utiliza para almacenar los mensajes generados en las tareas, 
  //que serán posteriormente transmitidos a la vista para su visualización
  private $mensajes;

  /**
   * Constructor que crea automáticamente un objeto modelo en el controlador e
   * inicializa los mensajes a vacío
   */
  public function __construct() {
    $this->modelo = new modelo();
    $this->mensajes = [];
  }

  /**
   * Método que envía al usuario a la página de inicio del sitio y le asigna 
   * el título de manera dinámica
   */
  public function index() {

  if(!isset($_SESSION['rol'])){
    //Mostramos la página de inicio 
    include_once 'vistas/login.php';
  
  }else{
    if($_SESSION['rol']=="admin"){
      include_once 'index.php?accion=inicioAdmin';
    }else if($_SESSION['rol']=="profesor"){
      include_once 'index.php?accion=inicioProf';
    }
  }



  }

  public function usuariosAdmin()
  {
    include_once 'vistas/usuariosAdmin.php';
  }

  public function incidenciasAdmin(){
    include_once 'vistas/incidenciasAdmin.php';
  }

  public function incidenciasProf(){
    include_once 'vistas/incidenciasProf.php';
  }

  public function mensajesProf(){
    include_once 'vistas/mensajesProf.php';
  }

  public function mensajesAdmin(){
    include_once 'vistas/mensajesAdmin.php';
  }

  public function logs(){
    include_once 'vistas/logs.php';
  }
  
  public function Incidencias(){
    include_once 'vistas/añadirIncidencias.php';
  }  

  public function logear() {

    $nombre = $_POST['nombreentrar'];
    $contraseña = $_POST['cntentrar'];

    if(isset($_POST['entrar'])){ // y hermos recibido las variables del formulario y éstas no están vacías...
        if(isset($_POST) and (!empty($_POST))){
          
            
    // Realizamos la consulta y almacenmos los resultados en la variable $resultModelo
    $resultModelo = $this->modelo->logear($nombre,$contraseña);
    $array = $resultModelo['datos'];
    // Si la consulta se realizó correctamente transferimos los datos obtenidos
    // de la consulta del modelo ($resultModelo["datos"]) a nuestro array parámetros
    // ($parametros["datos"]), que será el que le pasaremos a la vista para visualizarlos
      if($resultModelo['resultado']=="correcto"){

        $_SESSION['usuario']=$array['usuario'];
        $_SESSION['rol']=$array['rol'];
        $_SESSION['departamento']=$array['departamento'];
      }
      //Definimos el mensaje para el alert de la vista de que todo fue correctamente
      if($resultModelo['resultado'] =="correcto" && $array['rol'] == "admin"){
        include_once 'vistas/inicioAdmin.php';
      }else if ($resultModelo['resultado'] =="correcto" && $array['rol'] == "profesor"){
        include_once 'vistas/inicioProf.php';
      }else{
        include_once 'vistas/login.php';
      }

    }else  {
      //Definimos el mensaje para el alert de la vista de que se produjeron errores al realizar el listado
      $this->mensajes[] = [
          "tipo" => "danger",
          "mensaje" => "No pudo logearse <br/>({$resultModelo["error"]})"
      ];
    }
}
    }


    public function crear(){
      $nombre = $_POST['nombre'];
      $contraseña = $_POST['contraseña'];
      $email = $_POST['email'];
      $departamento = $_POST['departamento'];
  
      if(isset($_POST['crear'])){ // y hermos recibido las variables del formulario y éstas no están vacías...
          if(isset($_POST) and (!empty($_POST))){
            
              
      // Realizamos la consulta y almacenmos los resultados en la variable $resultModelo
      $resultModelo = $this->modelo->crear([
        'nombre' => $nombre,
        'contraseña' => $contraseña,
        'email' => $email,
        'departamento' => $departamento
    ]);
      
      // Si la consulta se realizó correctamente transferimos los datos obtenidos
      // de la consulta del modelo ($resultModelo["datos"]) a nuestro array parámetros
      // ($parametros["datos"]), que será el que le pasaremos a la vista para visualizarlos

        //Definimos el mensaje para el alert de la vista de que todo fue correctamente

  
      }else  {
        //Definimos el mensaje para el alert de la vista de que se produjeron errores al realizar el listado
        $this->mensajes[] = [
            "tipo" => "danger",
            "mensaje" => "No pudo darse de alta <br/>({$resultModelo["error"]})"
        ];
      }

      $this->index();
  }

    }

    public function logout(){
      session_destroy();
      unset($_SESSION['usuario']);
      include_once 'vistas/login.php';
    }

    public function listarIncidenciasAdmin(){
      $regsxpag = (isset($_GET['regsxpag'])) ? (int) $_GET['regsxpag'] : 5;
        //Establecemos el la página que vamos a mostrar, por página,por defecto la 1
        $pagina = (isset($_GET['pagina'])) ? (int) $_GET['pagina'] : 1;

        //Definimos la variable $inicio que indique la posición del registro desde el que se
        // mostrarán los registros de una página dentro de la paginación.
        $inicio = ($pagina > 1) ? (($pagina * $regsxpag) - $regsxpag) : 0;
        $incidencias = $this->modelo->listarIncidenciasAdmin($inicio, $regsxpag);

      /* $incidencias = $this->modelo->listarIncidenciasAdmin(); */
      $datos = $incidencias['datos'];
      $paginacion = $incidencias['datosPaginacion'];
      include_once 'vistas/incidenciasAdmin.php';

    }

    public function listarIncidenciasProf(){
      $usuario= $_SESSION['usuario'];
      $regsxpag = (isset($_GET['regsxpag'])) ? (int) $_GET['regsxpag'] : 5;
        //Establecemos el la página que vamos a mostrar, por página,por defecto la 1
        $pagina = (isset($_GET['pagina'])) ? (int) $_GET['pagina'] : 1;

        //Definimos la variable $inicio que indique la posición del registro desde el que se
        // mostrarán los registros de una página dentro de la paginación.
        $inicio = ($pagina > 1) ? (($pagina * $regsxpag) - $regsxpag) : 0;
        $incidencias = $this->modelo->listarIncidenciasProf($usuario,$inicio, $regsxpag);
        var_dump($incidencias);

      /* $incidencias = $this->modelo->listarIncidenciasProf($usuario); */
      $datos = $incidencias['datos'];
      $paginacion = $incidencias['datosPaginacion'];
      include_once 'vistas/incidenciasProf.php';

    }

    public function eliminarIncidenciasAdmin(){
 
      if(isset($_GET['id'])){
        $id=$_GET['id'];
        $correcto = $this->modelo->eliminarIncidenciasAdmin($id);       
      }

      if($correcto==true && $_SESSION['rol']=="admin"){
        $this->listarIncidenciasAdmin();
      }else{
        $this->listarIncidenciasProf();
      }
    }

    public function agregarIncidencias(){

      $datos=[
        'incidencia'=>$_POST['incidencia'],
        'descripcion'=>$_POST['descripcion'],
        'usuario'=>$_SESSION['usuario'],
        'departamento'=>$_SESSION['departamento']
      ];
   
      $incidencias = $this->modelo->agregarIncidencias($datos);
      if($_SESSION['rol']=="admin"){
        $this->listarIncidenciasAdmin();
      }else{
        $this->listarIncidenciasProf();
      }

    }


    public function listarUsuarios(){
      $usuarios = $this->modelo->listarUsuarios();
      $datos = $usuarios['datos'];
      include_once 'vistas/usuariosAdmin.php';

    }

    public function hacerAdmin(){
      if(isset($_GET['id'])){
        $id=$_GET['id'];
        $hola= $this->modelo->hacerAdmin($id);       
      }
      var_dump($hola);

        $this->listarUsuarios();


    }


    public function generarPDFAdmin(){

        $datos = $this->modelo->listarIncidenciasAdmin();




        $incidencias = $datos['datos'];

        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',16);
        $pdf->Cell(45,10, 'USUARIO',1,0,'C',0);
        $pdf->Cell(45,10, 'INCIDENCIA',1,0,'C',0);
        $pdf->Cell(45,10, 'DESCRIPCION',1,0,'C',0);
        $pdf->Cell(60,10, 'FECHA',1,0,'C',0);
        foreach ($incidencias as $incidencia)  {
          $pdf->Cell(45,10, $incidencia['usuario'],1,0,'C',0);
            $pdf->Cell(45,10, $incidencia['incidencia'],1,0,'C',0);
            $pdf->Cell(45,10, $incidencia['descripcion'],1,0,'C',0);
            $pdf->Cell(60,10, $incidencia['fecha'],1,0,'C',0);


           $pdf->Ln(); 
        }
        
        $pdf->Output();
    }

    public function generarPDFProf(){
      $usuario = $_SESSION['usuario'];
      $datos = $this->modelo->listarIncidenciasProf($usuario);




      $incidencias = $datos['datos'];

      $pdf = new FPDF();
      $pdf->AddPage();
      $pdf->SetFont('Arial','B',16);
      $pdf->Cell(45,10, 'USUARIO',1,0,'C',0);
      $pdf->Cell(45,10, 'INCIDENCIA',1,0,'C',0);
      $pdf->Cell(45,10, 'DESCRIPCION',1,0,'C',0);
      $pdf->Cell(60,10, 'FECHA',1,0,'C',0);
      foreach ($incidencias as $incidencia)  {
        $pdf->Cell(45,10, $incidencia['usuario'],1,0,'C',0);
          $pdf->Cell(45,10, $incidencia['incidencia'],1,0,'C',0);
          $pdf->Cell(45,10, $incidencia['descripcion'],1,0,'C',0);
          $pdf->Cell(60,10, $incidencia['fecha'],1,0,'C',0);


         $pdf->Ln(); 
      }
      
      $pdf->Output();
  }

  }

  


 