<?php
function listaDept(){
    $departamentos = mostrarDept();

    // Opción por defecto
    echo "<option value=''>-- SELECCIONA --</option>";

    // Usamos los datos obtenidos
    foreach ($departamentos as $row) {
        echo "<option value='" . $row["dept_no"] . "'>" . $row["dept_no"] . " - " . $row["dept_name"]. "</option>";
    }
}
?>