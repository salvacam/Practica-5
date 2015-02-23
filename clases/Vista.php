 <?php

class Vista {

    private $plantilla;
    private $datos;

    function __construct($plantilla = null, $datos = null) {
        $this->plantilla = $plantilla;
        $this->datos = $datos;
    }

    private function leerPlantilla(){
        return file_get_contents("./plantilla/".$this->plantilla.".html");
    }
    
    public function renderDatos() {
        $salida = $this->leerPlantilla();
        foreach ($this->datos as $indice => $valor) {
            $salida = str_replace("{".$indice."}", $valor, $salida);
        }
        return $salida;
    }

    public function render() {
        print $this->renderDatos();
    }

    public function getPlantilla() {
        return $this->plantilla;
    }

    public function getDatos() {
        return $this->datos;
    }

    public function setPlantilla($plantilla) {
        $this->plantilla = $plantilla;
    }

    public function setDatos($datos) {
        $this->datos = $datos;
    }

}
