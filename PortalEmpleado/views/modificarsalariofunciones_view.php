<?php
function listaEmpleados(){
    $empleados = mostrarEmp();

    // Opción por defecto
    echo "<option value=''>-- SELECCIONA --</option>";

    // Usamos los datos obtenidos
    foreach ($empleados as $row) {
        echo "<option value='" . $row["emp_no"] . "'>" . $row["emp_no"] . " - " . $row["first_name"] . " " . $row["last_name"]. "</option>";
    }
}
?>