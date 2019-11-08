<?php

class Layout
{  

    //validamos en que directorio debemos buscar los asset, para la validacion revisamos si existe el parametro page en el query string de la url
    private $directory; //
    function __construct($isPage)
    {
        $this->directory = ($isPage) ? "../" : "";
    }

    public function printHeader()
    {

        $header = <<<EOF
    <header>
    <div class="collapse bg-dark" id="navbarHeader">
      <div class="container">
        <div class="row">
          <div class="col-sm-8 col-md-7 py-4">
            <h4 class="text-white">Sobre esta web</h4>
            <p class="text-muted">Registros de estudiante</p>
          </div>
          <div class="col-sm-4 offset-md-1 py-4">
            <ul class="list-unstyled">
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="navbar navbar-dark bg-dark shadow-sm">
      <div class="container d-flex justify-content-between">
        <a href="../index.php" class="navbar-brand d-flex align-items-center">
          <i class="fa fa-address-card"></i>&nbsp;&nbsp;
          <strong>Estudiante</strong>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      </div>
    </div>
    </header>
EOF;


        echo $header;
    }

    public function printFooter()
    {
       $year = date('Y');
        $footer = <<<EOF
<footer class="text-muted">
  <div class="container">
    <p class="float-right">
      <a href="#"><i class="fa fa-arrow-up"></i> volver arriba</a>
    </p>
    <p>Estudiante ITLA © {$year}
  </div>
</footer>

<script type="text/javascript" src="{$this->directory}assets\js\plugin\jquery\jquery.js"></script>
<script type="text/javascript" src="{$this->directory}assets\js\bootstrap.bundle.js"></script>
<script type="text/javascript" src="{$this->directory}assets\js\bootstrap.js"></script>
<link rel="stylesheet" type="text/css" href="{$this->directory}assets\css\bootstrap-grid.css">
<link rel="stylesheet" type="text/css" href="{$this->directory}assets\css\bootstrap-reboot.css">
<link rel="stylesheet" type="text/css" href="{$this->directory}assets\css\bootstrap.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
EOF;

        echo $footer; // debemos usar globals para acceder a las variables declarada fuera de la funcion
    }
}
