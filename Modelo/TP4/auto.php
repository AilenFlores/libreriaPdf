<?php 
class Auto extends BaseDatos {
    private $patente;
    private $marca;
    private $modelo;
    private $ObjDuenioDNI;
    private $mensajeoperacion;
    
   
    public function __construct(){
        parent::__construct();
        $this->patente="";
        $this->marca="";
        $this->modelo="";
        $this->ObjDuenioDNI="";
        $this->mensajeoperacion ="";
    }
    public function setear($patente,$marca,$modelo,$ObjDuenioDNI){
        $this->setPatente($patente);
        $this->setMarca($marca);
        $this->setModelo($modelo);
        $this->setObjDuenioDNI($ObjDuenioDNI);
    }
    
    public function getPatente(){
        return $this->patente;
        
    }
    public function setPatente($valor){
        $this->patente = $valor;
        
    }

    public function getMarca(){
        return $this->marca;
        
    }
    public function setMarca($valor){
        $this->marca = $valor;
        
    }

    public function getModelo(){
        return $this->modelo;
        
    }
    public function setModelo($valor){
        $this->modelo = $valor;
        
    }

    public function getObjDuenioDNI(){
        return $this->ObjDuenioDNI;
        
    }
    public function setObjDuenioDNI($valor){
        $this->ObjDuenioDNI = $valor;
        
    }

    
    public function getmensajeoperacion(){
        return $this->mensajeoperacion;
        
    }
    public function setmensajeoperacion($valor){
        $this->mensajeoperacion = $valor;
        
    }
    
    
    public function cargar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="SELECT * FROM auto WHERE patente = ".$this->getPatente();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if($res>-1){
                if($res>0){
                    $row = $base->Registro();
                    $this->setear($row['patente'], $row['marca'], $row['modelo'], $row['DniDuenio']);
                    
                }
            }
        } else {
            $this->setmensajeoperacion("auto->listar: ".$base->getError());
        }
        return $resp;
    
        
    }

    public function insertar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="INSERT INTO auto(patente,marca,modelo,DniDuenio)  VALUES('".$this->getPatente()."','".$this->getMarca()."','".$this->getModelo()."','".$this->getObjDuenioDNI()."');";
        if ($base->Iniciar()) {
            if ($elid = $base->Ejecutar($sql)) {
                $this->setPatente($elid);
                $resp = true;
            } else {
                $this->setmensajeoperacion("auto->insertar: ".$base->getError());
            }
        } else {
            $this->setmensajeoperacion("auto->insertar: ".$base->getError());
        }
        return $resp;
    }

    public function modificar(){
        $resp = false;
        $base=new BaseDatos();
        $sql = "UPDATE auto SET marca = '".$this->getMarca()."',modelo = '".$this->getModelo()."',DniDuenio = '".$this->getObjDuenioDNI()."' WHERE patente = '".$this->getPatente()."'";;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("auto->modificar: ".$base->getError());
            }
        } else {
            $this->setmensajeoperacion("auto->modificar: ".$base->getError());
        }
        return $resp;
    }

    public function eliminar(){
        $resp = false;
        $base=new BaseDatos();
        $sql = "DELETE FROM auto WHERE patente='" . $this->getPatente() . "'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setmensajeoperacion("auto->eliminar: ".$base->getError());
            }
        } else {
            $this->setmensajeoperacion("auto->eliminar: ".$base->getError());
        }
        return $resp;
    }


    public static function listar($parametro=""){
        $arreglo = array();
        $base=new BaseDatos();
        $sql="SELECT * FROM auto ";
        if ($parametro!="") {
            $sql.='WHERE '.$parametro;
        }
        $res = $base->Ejecutar($sql);
        if($res>-1){
            if($res>0){
                
                while ($row = $base->Registro()){
                    $obj= new Auto();
                    $obj->setear($row['Patente'], $row['Marca'], $row['Modelo'], NULL );

                    $duenioDni = $row['DniDuenio'];
                    $duenio = new Persona();
                    $duenio->setNroDni($duenioDni);
                    $duenio->cargar();
    
                    $obj->setObjDuenioDNI($duenio);
                    array_push($arreglo, $obj);
                }
               
            }
            
        } else {
            $this->setmensajeoperacion("auto->listar: ".$base->getError());
        }
 
        return $arreglo;
    }
    
}


?>