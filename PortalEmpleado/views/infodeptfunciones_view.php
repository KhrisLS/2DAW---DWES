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

function mostrarManager($datos){
    echo "<h3>Manager</h3>";
    echo "<table border='1'>";
    echo "<tr><th>EMP_NO</th><th>NOMBRE</th><th>APELLIDO</th><th>FECHA NACIMIENTO</th><th>GENERO</th><th>FECHA CONTRATO</th></tr>";
    
    // Usamos los datos obtenidos
    foreach ($datos as $row) {
        echo "<tr><td>" . $row["emp_no"] . "</td><td>" . $row["first_name"] . "</td><td>" . $row["last_name"] . "</td><td>" . $row["birth_date"] . "</td><td>" . $row["gender"] . "</td><td>" . $row["hire_date"] . "</td></tr>";
    }
    echo "</table>";
}

function mostrarEmpleados($datos){
    echo "<h3>Historial de Cargos</h3>";
    echo "<table border='1'>";
    echo "<tr><th>EMP_NO</th><th>TITULO</th><th>FECHA INICIO</th><th>FECHA FIN</th></tr>";
    
    // Usamos los datos obtenidos
    foreach ($datos as $row) {
        echo "<tr><td>" . $row["emp_no"] . "</td><td>" . $row["title"] . "</td><td>" . $row["from_date"] . "</td><td>" . $row["to_date"] . "</td></tr>";
    }
    echo "</table>";
}

?>