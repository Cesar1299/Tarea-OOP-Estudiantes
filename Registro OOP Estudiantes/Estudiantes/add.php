<?php
//incluimos los archivos php que estaremos utilizando

include '../layout\layout.php';
include '../helpers\utilities.php';
require_once 'estudiante.php';

$layout = new Layout(true);
$utilities = new Utilities();



//Iniciamos la session para poder acceder a los valores guardada en ella
session_start();

//Validamos si existen valores en la variable de $_POST 
if(isset($_POST['nombre']) && isset($_POST['apellidos']) && isset($_POST['carrera']) && isset($_POST['status']) && isset($_POST['materiasFav'])) {

    //Obtenemos el listado actual de estudiante almacenado en la session
    $estudiantes = $_SESSION['estudiantes'];

    $estudianteId = 1; //El Id del estudiante que vamos a crear

    if (!empty($estudiantes)) { //validamos si ya hay estudiantes creado
        $lastElement = $utilities->getLastElement($estudiantes); //Obtenemos el ultimo elemento del listado de heroe  
        $estudianteId =  $lastElement->id + 1; //como ya existen estudiante el id del nuevo heroe debe ser el id el ultimo + 1
    }

    $materias = explode(",", $_POST['materiasFav']);

    $newEstudiante= new Estudiante($estudianteId, $_POST['nombre'], $_POST['apellidos'], $_POST['carrera'],$materias,$_POST['status']);

    if ($_FILES['profilePhoto']) {

        $typeReplace = str_replace("image/", "", $_FILES["profilePhoto"]["type"]);
        $type =  $_FILES["profilePhoto"]["type"];
        $size =  $_FILES["profilePhoto"]["size"];
        $tmpname = $_FILES["profilePhoto"]["tmp_name"];
        $directory = "../Estudiantes";
        $name = 'img/' . $estudianteId . '.' . $typeReplace;

        $isSuccess = $utilities->uploadImage($directory, $name, $tmpname, $type, $size);



        if ($isSuccess) {
            $newEstudiante->profilePhoto = $name;
        }
    }

    array_push($estudiantes, $newEstudiante);

    $_SESSION['estudiantes'] = $estudiantes; 

    header("Location: ../index.php"); //enviamos a la pagina principal del website
    exit(); //esto detiene la ejecucion del php para que se realice el redireccionamiento
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Agregar estudiante</title>
</head>

<body>

    <?php $layout->printHeader(); ?>

    <main role="main">

        <div class="card">
            <div class="card-header">
                <a href="../index.php" class="btn btn-warning"><i class="fa fa-arrow-left"></i>  </a> Registrar estudiante
            </div>
            <div class="card-body">

                <form method="POST" enctype="multipart/form-data" action="add.php">

                    <div class="col-md-4">
                        <div class="form-group">

                            <label for="nombre">Nombre</label>
                            <input type="text" name="nombre" class="form-control" id="nombre" placeholder="Introduzca el nombre ">

                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">

                            <label for="apellidos">Apellido</label>
                            <input type="text" name="apellidos" class="form-control" id="apellidos" placeholder="Introduzca el apellido ">

                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="carrera"> Carrera </label>
                            <select name="carrera" class="form-control" id="carrera">

                                <?php foreach ($utilities->carreras as $id => $text) : ?>
                                    <option value="<?php echo $id; ?>"><?php echo $text; ?></option>
                                <?php endforeach; ?>


                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">

                            <label for="materiasFav">Materias</label>
                            <textarea name="materiasFav" class="form-control" id="materiasFav" placeholder="Introduzca las materias "></textarea>
                            <small id="materiasFav" class="form-text text-muted">Colocar las materias separados por comas</small>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">

                            <label for="profilePhoto">Foto de perfil</label>
                            <input name="profilePhoto" type="file" class="form-control" id="materiasFav" />

                        </div>
                    </div>

                    <div class="col-md-4">
                    <div class="form-group">
                    
                    <input class="form-check-input" type="radio" name="status" id="statusA" value="Activo" checked>
                    <label class="form-check-label lead" for="statusA">
                      Activo
                    </label>
                  </div>
             
                    <input class="form-check-input" type="radio" name="status" id="statusI" value="Inactivo">
                    <label class="form-check-label lead" for="statusI">
                      Inactivo
                    </label>
                  </div>
                 </div>
               </div>

                    <button type="submit" class="btn btn-primary"><i class="fa fa-plus-square"></i> Crear estudiante</button>
                </form>

            </div>
        </div>

    </main>

    <?php $layout->printFooter(); ?>

</body>

</html>