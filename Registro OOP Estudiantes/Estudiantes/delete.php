<?php
//incluimos los archivos php que estaremos utilizando
require_once '../helpers/utilities.php';
require_once 'estudiante.php';

$utilities = new Utilities();

//Iniciamos la session para poder acceder a los valores guardada en ella
session_start();

//Obtenemos el listado actual de heroes almacenado en la session
$personajes = $_SESSION['estudiantes'];

$containId = isset($_GET['id']); //validamos si hay un parametro id en el query string de la url
$heroId = 0;

$element = [];

if ($containId) {
    $heroId = $_GET['id']; //El Id del personaje que vamos a editar   
    $elementIndex = $utilities->getIndexElement($personajes, 'id', $heroId); //Obtenemos el indice del elemento en el array del listado de heroes que vamos a editar       
    
    unset($personajes[$elementIndex]); 
    $_SESSION['estudiantes'] = $personajes; 
}

 header("Location: ../index.php"); //enviamos a la pagina principal del website
 exit(); //esto detiene la ejecucion del php para que se realice el redireccionamiento

?>