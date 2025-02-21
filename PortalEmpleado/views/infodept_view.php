<?php
require_once('infodeptfunciones_view.php');
?>
<html>
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
     <title>Información por Departamentos</title>
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
        <h2>Información por Departamentos</h2>
        <form id="" name="" action="" method="post">
            <label for="dept_name">Departamento: </label>
            <select id="dept_name" name="dept_name">
                <?php listaDept(); ?>
            </select><br><br>
            
            <input type="submit" name="submit" value="Visualizar Información">
        </form>
    </main>
</body>
</html>


