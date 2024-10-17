<?php 
include_once("../../Estructura/Cabecera.php"); 
$datos = data_submitted();
$datos['accion'] = "listar";
include_once("accion.php");
?>
<main class="flex-fill bg-light">
<!-- Lista de Personas -->

    <div class="container my-4">
        <div class="card">
            <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0 text-primary">Lista de Personas:</h5>
                    <a class="btn btn-primary" role="button" href="accion.php?accion=registros">Descargar Registros</a>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover table-sm"> 
                        <thead class="table-secondary"> 
                            <tr>
                                <th scope="col">DNI</th>
                                <th scope="col">Nombre</th>
                                <th scope="col" class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Verifico si hay resultados en la variable $lista que se implementa en accion.php
                            if (isset($lista) && count($lista) > 0) {
                                foreach ($lista as $personaObj) {
                                    echo '<tr>';
                                    echo '<td>' . $personaObj['nroDni'] . '</td>';
                                    echo '<td>' . $personaObj['nombre'] . ' ' . $personaObj['apellido'] . '</td>';
                                    echo '<td class="text-center">
                                            <a class="btn btn-secondary btn-sm" role="button" href="autosPersona.php?nroDni=' . $personaObj['nroDni'] . '">Ver Información</a>
                                          </td>';
                                    echo '</tr>';
                                }
                            } else {
                                echo '<tr><td colspan="3" class="alert alert-info text-center">No se encontraron registros.</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
<?php include_once("../../Estructura/pie.php"); ?>
