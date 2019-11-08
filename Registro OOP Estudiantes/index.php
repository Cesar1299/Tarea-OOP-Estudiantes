<?php
//incluimos los archivos php que estaremos utilizando
include 'layout\layout.php';
include 'helpers\utilities.php';
require_once 'Estudiantes/estudiante.php';

$layout = new Layout(false);
$utilities = new Utilities();

//Iniciamos la session para poder acceder a los valores guardada en ella
session_start();

$_SESSION['estudiantes'] = isset($_SESSION['estudiantes']) ? $_SESSION['estudiantes'] : array(); //Inicializamos el listado de heroes en la session en caso de no existir pero si existe tomamos los valores almacenados en la seccion

//Obtenemos el listado actual de heroes almacenado en la session
$listadoEstudiantes = $_SESSION['estudiantes'];

if (!empty($listadoEstudiantes)) {

    if (isset($_GET['Carrera'])) { //Validamos si existe un parametro companyId en el query string de la url, si existe realizamos un filtro por el id de la compania

        $listadoEstudiantes = $utilities->searchProperty($listadoEstudiantes, 'carrera', $_GET['Carrera']); //Realizamos el filtro sobre el listado de heroes en la propiedad companyId por el valor que pasamos en la url

    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Estudiante</title>
</head>

<body>

    <?php $layout->printHeader(); ?>


    <main role="main">
        <section class="jumbotron text-center">
            <div class="container">
                <h1 class="jumbotron-heading">Estudiante</h1>
                <p class="lead text-muted">Listado de Estudiante</p>

                <p>
                    <a href="Estudiantes/add.php"><a href="Estudiantes/add.php" class="btn btn-primary my-2"><i class="fa fa-plus-square"></i> Agregar nuevo estudiante</a></a>
                </p>
            </div>
        </section>

        <div class="album py-5 bg-light">
            <div class="container">

                <div class="row">
                    <div class="col-md-9"></div>

                    <div class="col-md-3">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <a href="index.php" class="btn btn-secondary">TODOS</a>
                            <a href="index.php?Carrera=1" class="btn btn-secondary">Software</a>
                            <a href="index.php?Carrera=2" class="btn btn-secondary">Multimedia</a>
                            <a href="index.php?Carrera=3" class="btn btn-secondary">Mecatronica</a>
                            <a href="index.php?Carrera=4" class="btn btn-secondary">Seguridad</a>
                            <a href="index.php?Carrera=5" class="btn btn-secondary">Redes</a>
                        </div>
                    </div>
                </div>
                <div class="row">

                    <?php if (empty($listadoEstudiantes)) : ?>

                        <h2>No hay Estudiante registrado, <a href="Estudiantes/add.php" class="btn btn-primary my-2"><i class="fa fa-plus-square"></i> Agregar nuevo estudiante</a> </h2>

                    <?php else : ?>

                        <?php foreach ($listadoEstudiantes as $estudiante) : ?>

                            <div class="col-md-4">
                                <div class="card mb-4 shadow-sm">
                                
                                <img width="100%" height="225px" src="<?php echo "Estudiantes/".$estudiante->profilePhoto; ?>" alt="">

                                    <div class="card-body">
                                        <p class="card-text"><strong> <?php echo $estudiante->nombre; ?> </strong></p>
                                        
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="btn-group">
                                            <a href="Estudiantes/detail.php?id=<?php echo $estudiante->id ?>" class="btn text-white btn-sm bg-primary btn-outline-secondary">Ver</a>
                                                <a href="Estudiantes/edit.php?id=<?php echo $estudiante->id ?>" class="btn text-white btn-sm bg-warning btn-outline-secondary">Editar</a>
                                                <a href="Estudiantes/delete.php?id=<?php echo $estudiante->id ?>" class="btn text-white btn-sm bg-danger btn-outline-secondary">Eliminar</a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
    </main>

    <?php $layout->printFooter(); ?>

</body>

</html>