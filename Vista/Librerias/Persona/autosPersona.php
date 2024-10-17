<?php include ("../../Estructura/Cabecera.php"); ?>
<?php include_once("accion.php");?>
<?php
    $datos = data_submitted();
    if ($datos && isset($datos['nroDni'])) {
        $controlPersona = new AbmPersona();
        $resp = convert_array($controlPersona->buscar(['nroDni' => $datos['nroDni']]));
            if ($resp && isset($resp[0])) {
                $objeto = $resp[0]; // Persona encontrada
                $personaDNI = $objeto['nroDni'];
?>
<main class="flex-fill bg-light">
    <div class="container my-4">
        <div class="card mx-auto" style="max-width: 50rem;">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Resultado de búsqueda:</h5>
            </div>
            <div class="card-body">
                        <h6 class="text-primary">Información Dueño</h6>
                        <hr class="my-2">
                        <table class="table"> 
                            <thead>
                                <!-- Información del dueño -->
                                <tr>
                                    <th scope="col">DNI</th>
                                    <th scope="col">Nombre y Apellido</th>
                                    <th scope="col">Fecha de Nacimiento</th>
                                    <th scope="col">Teléfono</th>
                                    <th scope="col">Domicilio</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?php echo $objeto["nroDni"]; ?></td>
                                    <td><?php echo $objeto["nombre"] . " " . $objeto["apellido"]; ?></td>
                                    <td><?php echo $objeto["fechaNac"]; ?></td>
                                    <td><?php echo $objeto["telefono"]; ?></td>
                                    <td><?php echo $objeto["domicilio"] ?></td>
                                </tr>
                            </tbody>
                        </table>
                    
                        <?php
                        $controlAuto = new AbmAuto();
                        $autos = convert_array($controlAuto->buscar(['ObjDuenioDNI' => $personaDNI]));
                        if ($autos && count($autos) > 0) { ?>
                            <h6 class="text-primary">Autos Asociados</h6>
                            <hr class="my-2">
                            <table class="table">
                                <thead>
                                    <!-- Encabezado de la tabla de autos -->
                                    <tr>
                                        <th scope="col">Patente</th>
                                        <th scope="col">Marca</th>
                                        <th scope="col">Modelo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($autos as $auto) { ?>
                                        <tr>
                                            <td><?php echo $auto["patente"]; ?></td>
                                            <td><?php echo $auto["marca"]; ?></td>
                                            <td><?php echo $auto["modelo"] ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        <?php } else {
                            echo '<p class="text-danger">No se encontraron autos asociados a esta persona.</p>';
                        } ?>

                    <?php
                    } else {
                        $mensaje = "No se encontró persona solicitado.";
                        echo("<script>location.href = './index.php?msg=$mensaje';</script>");
                    }
                } else {
                    echo '<p class="text-danger">No se recibieron datos válidos para realizar la búsqueda.</p>';
                }
                ?>
                <div class="d-flex justify-content-end mt-3">
                    <?php
                     // Si se encontró una persona, muestra los botones de imprimir e ir a editar
                     if($resp && isset($resp[0])) {
                        echo '<a href="accion.php?accion=imprimir&nroDni=' . $objeto['nroDni'] . '" class="btn btn-primary me-2">Generar PDF</a>'; 
                    } 
                      ?>
                      <a href="index.php" class="btn btn-danger">Volver</a>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include (STRUCTURE_PATH."pie.php"); ?>
