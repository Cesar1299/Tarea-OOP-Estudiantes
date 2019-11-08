<?php

    class Estudiante{

        public $id;
        public $nombre;
        public $apellido;
        public $carrera;
        public $materiasFav;
        public $status;
        public $profilePhoto;

        function __construct($id,$nombre,$apellido,$carrera,$materiasFav,$status)
        {
            
            $this->id = $id;
            $this->nombre = $nombre;
            $this->apellido = $apellido;
            $this->carrera = $carrera;
            $this->materiasFav = $materiasFav;
            $this->status = $status;
    
        }

    public function getTextCarrera(){

        $utilities = new Utilities();

        if($this->carrera != 0 && $this->carrera !=null){
            return $utilities->carrera[$this->carrera];
        }

        return "";      

    }

    public function getMaterias(){       

        if( !empty($this->materiasFav) && $this->materiasFav !=null){
            return implode(",",$this->materiasFav);
        }

        return "";      

    }

}

?>