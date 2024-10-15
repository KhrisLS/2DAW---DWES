<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ej6.2</title>
</head>
<body>
    <h1>Datos Alumnos</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
        <label for="nombre">Nombre: </label>
        <input type="text" name="nombre"><br><br>
        <label for="apellido1">Apellido1: </label>
        <input type="text" name="apellido1"><br><br>
        <label for="apellido2">Apellido2: </label>
        <input type="text" name="apellido2"><br><br>
        <label for="fechaNacimiento">Fecha Nacimiento: </label>
        <input type="date" name="fechaNacimiento" ><br><br>
        <label for="localidad">Localidad: </label>
        <input type="text" name="localidad" ><br><br>
        <button type="submit">Enviar</button>
        <button type="reset">Borrar</button>
    </form>

    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nombre = test_input($_POST["nombre"]);
            $apellido1 = test_input($_POST["apellido1"]);
            $apellido2 = test_input($_POST["apellido2"]);
            $fechaNacimiento = test_input($_POST["fechaNacimiento"]);
            $localidad = test_input($_POST["localidad"]);
            
            almacenarDatos($nombre, $apellido1, $apellido2, $fechaNacimiento, $localidad);
        }
        
        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        function almacenarDatos($nombre, $apellido1, $apellido2, $fechaNacimiento, $localidad) {
            $f1 = fopen("alumnos2.txt", "a");
            $datos = establecerEspacios($nombre, $apellido1, $apellido2, $fechaNacimiento, $localidad);
            fwrite($f1, $datos . "\n"); 
            mensajeAviso();
            fclose($f1);

        }
            
        function establecerEspacios($nombre, $apellido1, $apellido2, $fechaNacimiento, $localidad) {
            $delimitador = "##";
            
            $datos = $nombre. $delimitador. $apellido1. $delimitador. $apellido2. $delimitador. $fechaNacimiento. $delimitador. $localidad;

            return $datos;
        }

        function mensajeAviso(){
            echo "<br>Los datos han sido almacenados correctamente.<br>";
        }
        

    ?>

</body>
</html>