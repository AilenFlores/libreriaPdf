<?php
include_once "../../../configuracion.php";
// Incluir la clase FPDF
require('../../../Util/fpdf/fpdf.php');
$resp = false;
$objTrans = new AbmPersona();
$objAuto = new AbmAuto();
if(!isset($datos)) {
    $datos = data_submitted();
} 

if (isset($datos['accion'])){
//////////////////////////////////////////imprimir comprobante auto///////////////////////////////////////
if ($datos["accion"] == "imprimir") {
    $array =convert_array($objTrans->buscar(['nroDni' => $datos['nroDni']]));
    $persona = $array[0];
    $autos = convert_array($objAuto->buscar(['ObjDuenioDNI' => $persona["nroDni"]]));
        // Crear el objeto PDF
       $pdf = new PDF("p", "mm", "Letter");
       $pdf->generarComprobante($persona, $autos);
    }
///////////////////////////////////// registro de todas las personas y sus autos/////////////////////////////////
elseif ($datos["accion"] == "registros"){
    $arrayFinal = []; 
    $arrayObjPersonas = convert_array($objTrans->buscar(null));
    foreach ($arrayObjPersonas as $persona) {
        // Buscar autos asociados al nroDni de la persona
        $autos = convert_array($objAuto->buscar(['ObjDuenioDNI' => $persona["nroDni"]]));
        // Asignar la cantidad de autos encontrados
        $persona["autos"] = count($autos);
        $arrayFinal[] = $persona;
    }
    // Generar el PDF con la lista de personas y sus autos
    $pdf = new PDF();
    $pdf->generarRegistro($arrayFinal);
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
else {
     if($datos['accion']=='listar'){
            $lista = convert_array($objTrans->buscar(null));
        } 
        else {
            $resp = $objTrans->abm($datos);
            if($resp){
                $mensaje = "La accion ".$datos['accion']." se realizo correctamente.";
            }else {
                $mensaje = "La accion ".$datos['accion']." no pudo concretarse.";
            }
            // Redirigir a la página de mensajes
            echo("<script>location.href = './index.php?msg=$mensaje';</script>");
        }
    }
}
        
?>
