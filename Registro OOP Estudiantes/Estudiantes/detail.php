<?php
//incluimos los archivos php que estaremos utilizando
include '../layout\layout.php';
include '../helpers\utilities.php';
require_once 'estudiante.php';

$layout = new Layout(true);
$utilities = new Utilities();


//Iniciamos la session para poder acceder a los valores guardada en ella
session_start();

//Obtenemos el listado actual de heroes almacenado en la session
$estudiantes = $_SESSION['estudiantes'];

$containId = isset($_GET['id']); //validamos si hay un parametro id en el query string de la url

$element;

if ($containId) {
    $element = $utilities->searchProperty($estudiantes, 'id', $_GET['id'])[0]; //buscamos el elemento con id especificado en el query string de la url el cual obtenemos con la variable $_GET['id'],debemos especificar que es el elemento [0] del array ya que no queremos un listado sino el unico elemento que cumple con la condicion 
}

if(isset($_POST['nombre']) && isset($_POST['apellidos']) && isset($_POST['carrera']) && isset($_POST['status']) && isset($_POST['materiasFav'])){

    $materias = explode(",", $_POST['materiasFav']);
  
    $actualizarEstudiante = new Estudiante($_GET['id'], $_POST['nombre'], $_POST['apellidos'], $_POST['carrera'],$materias,$_POST['status']);
  
    $estudiantes[$indexElemento] = $actualizarEstudiante;
  
    $_SESSION ['estudiantes'] = $estudiantes;
    
      header("Location:../index.php");
    exit();
  }

?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Registro de Estudiantes</title>
  <link href="../styles/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../styles/css/scrolling-nav.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<body id="page-top">

  <?php $layout->printHeader();?>
 
    </div>
  </header>

  <section id="about">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 mx-auto">
        <div class="container text-center">
          <h2>Detalles del estudiante <?php echo $element->nombre;?></h2>
            <div class="card container text-center" style="width: 21rem;">
               <div class="card-body">
                
               <img width="280px" height="250px" src="<?php echo $element->profilePhoto;?>"/>
               </div>
               <hr>
               
                <div class="card-body">
                    <h5 class="card-title">Nombre y Apellido</h5>
                    <p class="card-text"><?php echo $element->nombre,' ', $element->apellido;?> </p>
                </div>
                <hr>
                <div class="card-body">
                    <h5 class="card-title">Estatus actual</h5>
                    <p class="card-text"><?php echo $element->status;?> </p>
                </div>
                <hr>
                <div class="card-body">
                    <h5 class="card-title">Carrera</h5>
                    <p class="card-text"><?php echo $element->carrera;?> </p>
                </div>
                <hr>
                <div class="card-body">
                    <h5 class="card-title">Materias Favoritas</h5>
                    <p class="card-text"><?php echo $element->getTextMaterias()?> </p>
                </div>
                <hr>
                <div class="card-body">
                    <a href="edit.php?ID=<?php echo $element->id ?>" class="card-link">Editar al estudiante</a>
                </div>
             </div>  
          
        </div>
      </div>
    </div>
  </section>

 <?php $layout->printFooter(); ?>
 
	</body>
</html>