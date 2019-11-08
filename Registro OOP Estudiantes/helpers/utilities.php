<?php

class Utilities
{

    public $carreras = [1=>"Software", 2=>"Multimedia", 3=>"Mecatronica", 4=>"Seguridad", 5=>"Redes"];

    /* Esta funcion retorna el ultimo elemento del un array */
    public function getLastElement($list)
    {
        $countList = count($list);
        $lastElement = $list[$countList - 1];

        return $lastElement;
    }

    /* Esta funcion realiza una busqueda en un listado por la propiedad y valor que pasemos por parametros
   Retorna: Un listado con el filtro que realizamos */
    public function searchProperty($list, $property, $value)
    {
        $filter = [];

        foreach ($list as $item) {

            if ($item->$property == $value) {
                array_push($filter, $item);
            }
        }

        return $filter;
    }

    /* Esta funcion realiza una busqueda en un listado por la propiedad y valor que pasemos por parametros
   Retorna: El index del primer elemento que cumpla con la condicion de busqueda */
    public function getIndexElement($list, $property, $value)
    {
        $index = 0;
      
        foreach ($list as $key => $item) {

            if ($item->$property == $value) {
                $index = $key;
                break;
            }           
        }
        return $index;
    }

    public function uploadImage($directory, $name, $tmpFile, $type, $size)
    {
        $isSuccess = false;
    
        if ((($type == "image/gif")
                || ($type == "image/jpeg")
                || ($type == "image/png")
                || ($type == "image/jpg")
                || ($type == "image/JPG")
                || ($type == "image/pjpeg"))
            && ($size < 1000000)
        ) {
    
            if (!file_exists($directory)) {
    
                mkdir($directory, 0777, true);
    
                if (file_exists($directory)) {
    
                    if (file_exists($name)) {
                        unlink($name);
                    }
    
                    move_uploaded_file($tmpFile,  $name);
                    $isSuccess = true;
                }
            } else {
    
                if (file_exists($name)) {
                    unlink($name);
                }
    
                move_uploaded_file($tmpFile, $name);
                $isSuccess = true;
            }
        } else {
            $isSuccess = false;
        }
    
        return $isSuccess;
    }
}
