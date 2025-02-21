<?php
require_once ("models/infodept_model.php");
require_once ("controllers/funcionesgenerales_controller.php");
require_once ("controllers/infodeptfunciones_controller.php");
require_once('views/infodept_view.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dept = $_POST['dept_no'];
    
    buscarManager($dept);
    buscarEmpleados($dept);
}

?>