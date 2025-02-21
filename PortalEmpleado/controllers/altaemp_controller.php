<?php
require_once ("models/altaemp_model.php");
require_once ("controllers/funcionesgenerales_controller.php");
require_once ("controllers/altaempfunciones_controller.php");
require_once('views/altaemp_view.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['first_name'];
    $apellido = $_POST['last_name'];
    $nacimiento = $_POST['birth_date'];
    $genero = $_POST['gender'];
    $dept = $_POST['dept_no'];
    $salario = $_POST['salary'];
    $cargo = $_POST['title'];

    $nombre = test_input($nombre);
    $apellido = test_input($apellido);
    $nacimiento = test_input($nacimiento);
    $genero = test_input($genero);
    $dept = test_input($dept);
    $salario = test_input($salario);
    $cargo = test_input($cargo);

    $numEmp = asignarNumEmpleado();

    darAltaEmpleado($numEmp, $nombre, $apellido, $nacimiento, $genero, $dept, $salario, $cargo);
}
?>