<?php
require_once('vidalaboralfunciones_view.php');
?>
<html>
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
     <title>Vida Laboral</title>
    <link rel="stylesheet" href="css/main.css">
 </head>
 <body>
    <header>
        <h1>Portal RRHH</h1>
    </header>
    <nav>
        <a href="altaEmp.php">Alta Empleado</a>
        <a href="altaMasivaEmp.php">Alta Masiva Empleados</a>
        <a href="modificarSalario.php">Modificar Salario</a>
        <a href="vidaLaboral.php">Vida Laboral</a>
        <a href="infoDept.php">Info Departamento</a>
        <a href="cambioDept.php">Cambio Departamento</a> 
		<a href="nuevoJefeDept.php">Nuevo Jefe Departamento</a> 
		<a href="bajaEmp.php">Baja Empleado</a> 
    </nav>
    <main id="formus">
        <h2>Vida Laboral</h2>
        <form id="" name="" action="" method="post">
            <label for="emp_no">Empleado: </label>
            <select id="emp_no" name="emp_no">
                <?php listaEmpleados(); ?>
            </select><br><br>
            <input type="submit" name="datos" value="Ver Datos Personales">
            <input type="submit" name="departamentos" value="Ver Historial de Departamentos">
            <input type="submit" name="cargos" value="Ver Historial de Cargos">
            <input type="submit" name="salarios" value="Ver Historial de Salarios">
        </form>
    </main>
</body>
</html>


