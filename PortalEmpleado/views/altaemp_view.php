<?php
require_once('altaempfunciones_view.php');
?>
<html>
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
     <title>Alta Empleado</title>
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
        <h2>Alta Empleado</h2>
        <form id="" name="" action="" method="post">
            <label for="first_name">Nombre: </label>
            <input type="text" id="first_name" name="first_name"><br><br>
            <label for="last_name">Apellido: </label>
            <input type="text" id="last_name" name="last_name"><br><br>
            <label for="birth_date">Fecha de Nacimiento: </label>
            <input type="date" id="birth_date" name="birth_date"><br><br>
            <label for="gender">Género: </label>
            <select id="gender" name="gender">
                <option value="M">Hombre</option>
                <option value="F">Mujer</option>
            </select><br><br>
            <label for="dept_no">Departamento: </label>
            <select id="dept_no" name="dept_no">
                <?php listaDept(); ?>
            </select><br><br>
            <label for="salary">Salario: </label>
            <input type="number" id="salary" name="salary"><br><br>
            <label for="title">Cargo: </label>
            <input type="text" id="title" name="title"><br><br>
            
            <input type="submit" name="submit" value="Dar de Alta">
        </form>
    </main>
</body>
</html>


