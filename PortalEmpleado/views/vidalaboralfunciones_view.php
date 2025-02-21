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

function mostrarInfo($datos){
    echo "<h3>Datos Personales</h3>";
    echo "<table border='1'>";
    echo "<tr><th>EMP_NO</th><th>NOMBRE</th><th>APELLIDO</th><th>FECHA NACIMIENTO</th><th>GENERO</th><th>FECHA CONTRATO</th></tr>";
    
    // Usamos los datos obtenidos
    foreach ($datos as $row) {
        echo "<tr><td>" . $row["emp_no"] . "</td><td>" . $row["first_name"] . "</td><td>" . $row["last_name"] . "</td><td>" . $row["birth_date"] . "</td><td>" . $row["gender"] . "</td><td>" . $row["hire_date"] . "</td></tr>";
    }
    echo "</table>";
}

function mostrarDepts($datos){
    echo "<h3>Historial de Departamentos</h3>";
    echo "<table border='1'>";
    echo "<tr><th>EMP_NO</th><th>DEPT_NO</th><th>DEPARTAMENTO</th><th>FECHA INICIO</th><th>FECHA FIN</th></tr>";
    
    // Usamos los datos obtenidos
    foreach ($datos as $row) {
        echo "<tr><td>" . $row["emp_no"] . "</td><td>" . $row["dept_no"] . "</td><td>" . $row["dept_name"] . "</td><td>" . $row["from_date"] . "</td><td>" . $row["to_date"] . "</td></tr>";
    }
    echo "</table>";
}

function mostrarCargoManager($datos){
    echo "<h2>Manager del departamento: ".$datos[0]['dept_name']."</h2>";
}

function mostrarCargos($datos){
    echo "<h3>Historial de Cargos</h3>";
    echo "<table border='1'>";
    echo "<tr><th>EMP_NO</th><th>TITULO</th><th>FECHA INICIO</th><th>FECHA FIN</th></tr>";
    
    // Usamos los datos obtenidos
    foreach ($datos as $row) {
        echo "<tr><td>" . $row["emp_no"] . "</td><td>" . $row["title"] . "</td><td>" . $row["from_date"] . "</td><td>" . $row["to_date"] . "</td></tr>";
    }
    echo "</table>";
}

function mostrarSalarios($datos){
    echo "<h3>Historial de Salarios</h3>";
    echo "<table border='1'>";
    echo "<tr><th>EMP_NO</th><th>SALARIO</th><th>FECHA INICIO</th><th>FECHA FIN</th></tr>";
    
    // Usamos los datos obtenidos
    foreach ($datos as $row) {
        echo "<tr><td>" . $row["emp_no"] . "</td><td>" . $row["salary"] . "</td><td>" . $row["from_date"] . "</td><td>" . $row["to_date"] . "</td></tr>";
    }
    echo "</table>";
}
?>