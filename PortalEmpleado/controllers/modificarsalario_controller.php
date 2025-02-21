<?php
require_once ("models/modificarsalario_model.php");
require_once ("controllers/funcionesgenerales_controller.php");
require_once ("controllers/modificarsalariofunciones_controller.php");
require_once('views/modificarsalario_view.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $emp = $_POST['emp_no'];
    $salario = $_POST['salary'];
    
    comprobarMismoDia($emp);
    modificarSalario($emp, $salario);
}
?>