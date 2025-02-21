<?php
require_once ("models/vidalaboral_model.php");
require_once ("controllers/funcionesgenerales_controller.php");
require_once ("controllers/vidalaboralfunciones_controller.php");
require_once('views/vidalaboral_view.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $emp = $_POST['emp_no'];
    
    if (isset($_POST['datos'])) {
        mostrarDatosPersonales($emp);
    }

    if (isset($_POST['departamentos'])) {
        mostrarHistorialDepartamentos($emp);
    }

    if (isset($_POST['cargos'])) {
        mostrarHistorialCargos($emp);
    }
    
    if (isset($_POST['salarios'])) {
        mostrarHistorialSalarios($emp);
    }
}
?>