
<?php
class AbmAuto{
    public function abm($datos){
        $resp = false;
        if($datos['accion']=='editar'){
            if($this->modificacion($datos)){
                $resp = true;
            }
        }
        if($datos['accion']=='borrar'){
            if($this->baja($datos)){
                $resp =true;
            }
        }
        if($datos['accion']=='nuevo'){
             // Verificar si el auto ya existe
             $resultados = $this->buscar(['patente' => $datos['patente']]);
             if ($resultados && count($resultados) > 0) { 
                 $resp = false; // Registro fallido
             } 
             else {
                if($this->alta($datos)){
                $resp =true;}
            }
        }
        return $resp;

    }
    //Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto

    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return Auto
     */
    private function cargarObjeto($param){
        $obj = null;
        if( array_key_exists('patente',$param) and array_key_exists('marca',$param) and array_key_exists('modelo',$param) and array_key_exists('ObjDuenioDNI',$param)){
            $obj = new Auto();
            $obj->setear($param['patente'], $param['marca'], $param['modelo'], $param['ObjDuenioDNI']);
        }
        return $obj;
    }
    
    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
     * @param array $param
     * @return Auto
     */
    private function cargarObjetoConClave($param){
        $obj = null;
        
        if( isset($param['patente']) ){
            $obj = new Auto();
            $obj->setear($param['patente'], null, null, null);  
        }
        return $obj;
    }
    
    
    /**
     * Corrobora que dentro del arreglo asociativo estan seteados los campos claves
     * @param array $param
     * @return boolean
     */
    
     private function seteadosCamposClaves($param) {
        $resp = false;
        if (isset($param["patente"])) 
            $resp = true;
        return $resp;
    }
    
    
    /**
     * 
     * @param array $param
     */
    public function alta($param){
        $resp = false;
        //$param['patente'] =null;
        $elObjtTabla = $this->cargarObjeto($param);
        if ($elObjtTabla!=null and $elObjtTabla->insertar()){
            $resp = true;
        }
        return $resp;
        
    }
    /**
     * permite eliminar un objeto 
     * @param array $param
     * @return boolean
     */
    public function baja($param){
        $resp = false;
        if ($this->seteadosCamposClaves($param)){
            $elObjtTabla = $this->cargarObjetoConClave($param);
            if ($elObjtTabla!=null and $elObjtTabla->eliminar()){
                $resp = true;
            }
        }
        
        return $resp;
    }
    
    /**
     * permite modificar un objeto
     * @param array $param
     * @return boolean
     */
    public function modificacion($param){
        $resp = false;
        if ($this->seteadosCamposClaves($param)){
            $elObjtTabla = $this->cargarObjeto($param);
            if($elObjtTabla!=null and $elObjtTabla->modificar()){
                $resp = true;
            }
        }
        return $resp;
    }
    
    /**
     * permite buscar un objeto
     * @param array $param
     * @return boolean
     */
    public function buscar($param){
        $where = " true ";
        if ($param<>NULL){
            if  (isset($param['patente']))
                $where.=" and patente='".$param['patente']."'";
            if  (isset($param['marca']))
                 $where.=" and marca='".$param['marca']."'";
            if  (isset($param['modelo']))
                $where.=" and modelo='".$param['modelo']."'";
            if  (isset($param['ObjDuenioDNI']))
                $where.=" and dniDuenio='".$param['ObjDuenioDNI']."'";
        }

            $arreglo = Auto::listar($where);  
            return $arreglo;   }




}
?>