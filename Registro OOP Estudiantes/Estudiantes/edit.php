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

$element = [];

if ($containId) {

    $element = $utilities->searchProperty($estudiantes, 'id', $_GET['id'])[0]; //buscamos el elemento con id especificado en el query string de la url el cual obtenemos con la variable $_GET['id'],debemos especificar que es el elemento [0] del array ya que no queremos un listado sino el unico elemento que cumple con la condicion 
    $elementIndex = $utilities->getIndexElement($estudiantes, 'id', $_GET['id']); //Obtenemos el indice del elemento en el array del listado de heroes que vamos a editar
}

if(isset($_POST['nombre']) && isset($_POST['apellidos']) && isset($_POST['carrera']) && isset($_POST['status']) && isset($_POST['materiasFav'])){

    $materias = explode(",", $_POST['materiasFav']);
  
    $actualizarEstudiante = new Estudiante($_GET['id'], $_POST['nombre'], $_POST['apellidos'], $_POST['carrera'],$materias,$_POST['status']);
    

    if ($_FILES['profilePhoto']) {

        if ($_FILES['profilePhoto']['error'] == 4) {
            $actualizarEstudiante->profilePhoto = $element->profilePhoto;
        } else {
            $typeReplace = str_replace("image/", "", $_FILES["profilePhoto"]["type"]);
            $type =  $_FILES["profilePhoto"]["type"];
            $size =  $_FILES["profilePhoto"]["size"];
            $tmpname = $_FILES["profilePhoto"]["tmp_name"];
            $directory = "../Estudiantes";
            $name = 'img/' . $heroId . '.' . $typeReplace;

            $isSuccess = $utilities->uploadImage($directory, $name, $tmpname, $type, $size);



            if ($isSuccess) {
                $actualizarEstudiante->profilePhoto = $name;
            }
        }
    }

    $estudiantes[$elementIndex] =  $actualizarEstudiante; //Actualizamos los datos del heroe en el listado de heroes utilizando el index obtenido del elemento

    $_SESSION['estudiantes'] = $estudiantes; // Actualizamos la informacion en la session

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
    <title>Editar</title>
</head>

<body>

    <?php $layout->printHeader(); ?>

    <main role="main">

        <?php if ($containId && !empty($element)) : ?>

            <div class="card">
                <div class="card-header">
                    <a href="../index.php" class="btn btn-warning"><i class="fa fa-arrow-left"></i>  </a> Editando Estudiante <?php echo $element->nombre ?>
                </div>
                <div class="card-body">

                    <form method="POST"  enctype="multipart/form-data" action="edit.php?id=<?php echo $element->id ?>">

                        <div class="col-md-4">
                            <div class="form-group">

                                <label for="nombre">Nombre</label>
                                <input type="text" value="<?php echo $element->nombre ?>" name="nombre" class="form-control" id="nombre" placeholder="Introduzca el nombre ">

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">

                                <label for="apellidos">Apellido</label>
                                <input type="text" value="<?php echo $element->apellido ?>" name="apellidos" class="form-control" id="apellidos" placeholder="Introduzca el apellido ">

                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="carrera"> Carrera </label>
                                <select name="carrera" class="form-control" id="carrera">

                                    <?php foreach ($utilities->carreras as $id => $text) : ?>
                                        <?php if ($id == $element->carrera) : ?>
                                            <option selected value="<?php echo $id; ?>"><?php echo $text; ?></option>
                                        <?php else : ?>
                                            <option value="<?php echo $id; ?>"><?php echo $text; ?></option>
                                        <?php endif; ?>

                                    <?php endforeach; ?>


                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">

                                <label for="materiasFav">Materias</label>
                                <textarea name="materiasFav" class="form-control" id="materiasFav" placeholder="Introduzca las materias "> <?php echo $element->getMaterias()?> </textarea>
                                <small id="materias" class="form-text text-muted">Colocar las materias separados por comas</small>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">

                                <label for="profilePhoto">Foto de perfil</label>
                                <input name="profilePhoto" type="file" class="form-control" id="profilePhoto" accept="image/*"/>

                            </div>
                        </div>

                        </div>
            </div>

            <div class="form-group col-md-7">
                
                 <label for="" class="lead"> Estado del estudiante</label>
                 <div class="form-check">
                    <input class="form-check-input" type="radio" name="status" id="status" value="Activo"  <?php if($element->status=="Activo") echo "checked";?>>
                    <label class="form-check-label lead" for="statusA">
                      Activo
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="status" id="status" value="Inactivo"<?php if($element->status=="Inactivo") echo "checked";?>>
                    <label class="form-check-label lead" for="statusI">
                      Inactivo
                    </label>
                  </div>
                 </div>
                 
               </div>

                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Guardar</button>
                    </form>    

        <?php else : ?>

            <h2>No existe</h2>

        <?php endif; ?>

    </main>

    <?php $layout->printFooter(); ?>

</body>

</html>