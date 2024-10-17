
<?php
class AbmPersona{

    public function abm($datos) {
        $resp = false; 
        // Acción de editar
        if ($datos['accion'] == 'editar') {
            //verificar si existe la persona
            if ($this->modificacion($datos)) {
                $resp = true; // Modificación exitosa
            }
        }
        // Acción de borrar
        if ($datos['accion'] == 'borrar') {
            $controlAuto = new AbmAuto();
            $autos = $controlAuto->buscar(['ObjDuenioDNI' => $datos['nroDni']]);
            // Si tiene autos asociados, no se puede eliminar
            if ($autos && count($autos) > 0) {
                $resp = false; // Baja fallida
            } else {
                if ($this->baja($datos)) {
                    $resp = true; // Baja exitosa
                }
            }
        }
        // Acción de nuevo
        if ($datos['accion'] == 'nuevo') {
            // Verificar si el dueño ya existe
            $resultados = $this->buscar(['nroDni' => $datos['nroDni']]);
            if ($resultados && count($resultados) > 0) { 
                $resp = false; // Registro fallido
            } else {
                if ($this->alta($datos)) {
                    $resp = true; // Registro exitoso
                } 
            }
        }
        return $resp; // Retornar el resultado final
    }
    
    //Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return Persona
     */
    private function cargarObjeto($param){
        $obj = null;
        if( array_key_exists('nroDni',$param) and array_key_exists('apellido',$param) and array_key_exists('nombre',$param) and array_key_exists('fechaNac',$param) and array_key_exists('telefono',$param) and array_key_exists('domicilio',$param)){
            $obj = new Persona();
            $obj->setear($param['nroDni'], $param['apellido'], $param['nombre'], $param['fechaNac'], $param['telefono'], $param['domicilio']);
        }
        return $obj;
    }
    
    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
     * @param array $param
     * @return Persona
     */
    private function cargarObjetoConClave($param){
        $obj = null;
        
        if( isset($param['nroDni']) ){
            $obj = new Persona();
            $obj->setear($param['nroDni'], null, null, null, null, null);
        }
        return $obj;
    }
    
    
    /**
     * Corrobora que dentro del arreglo asociativo estan seteados los campos claves
     * @param array $param
     * @return boolean
     */
    
    private function seteadosCamposClaves($param){
        $resp = false;
        if (isset($param['nroDni']))
            $resp = true;
        return $resp;
    }
    
    /**
     * 
     * @param array $param
     */
    public function alta($param){
        $resp = false;
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
            if  (isset($param['nroDni']))
                $where.=" and nroDni =".$param['nroDni'];
            if  (isset($param['apellido']))
                 $where.=" and apellido ='".$param['apellido']."'";
            if  (isset($param['nombre']))
                    $where.=" and nombre ='".$param['nombre']."'";
            if  (isset($param['fechaNac']))
                    $where.=" and fechaNac ='".$param['fechaNac']."'";
            if  (isset($param['telefono']))
                    $where.=" and telefono ='".$param['telefono']."'";
            if  (isset($param['domicilio']))
                    $where.=" and domicilio ='".$param['domicilio']."'";}

            $arreglo = Persona::listar($where);  
            return $arreglo;   }
    
}
?>