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
            
            comprobarValores($nombre, $apellido1, $apellido2, $fechaNacimiento, $localidad);

        }
        
        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        function comprobarValores($nombre, $apellido1, $apellido2, $fechaNacimiento, $localidad) {
            $nombreLongitud = 40;
            $apellido1Longitud = 41;
            $apellido2Longitud = 42;
            $fechaNacimientoLongitud = 10;
            $localidadLongitud = 27;
            $valido = true;
            
            if (strlen($nombre) > $nombreLongitud) {
                echo "<br>Nombre no puede tener más de $nombreLongitud caracteres.<br>";
                $valido = false;
            }
            
            if (strlen($apellido1) > $apellido1Longitud) {
                echo "<br>Apellido 1 no puede tener más de $apellido1Longitud caracteres.<br>";
                $valido = false;
            }
            
            if (strlen($apellido2) > $apellido2Longitud) {
                echo "<br>Apellido 2 no puede tener más de $apellido2Longitud caracteres.<br>";
                $valido = false;
            }
            
            if (strlen($fechaNacimiento) > $fechaNacimientoLongitud) {
                echo "<br>Fecha de nacimiento no puede tener más de $fechaNacimientoLongitud caracteres.<br>";
                $valido = false;
            }
            
            if (strlen($localidad) > $localidadLongitud) {
                echo "<br>Localidad no puede tener más de $localidadLongitud caracteres.<br>";
                $valido = false;
            }

            if (!$valido) {
                exit();
            }else{
                almacenarDatos($nombre, $apellido1, $apellido2, $fechaNacimiento, $localidad);
            }
        }

        function almacenarDatos($nombre, $apellido1, $apellido2, $fechaNacimiento, $localidad) {
            $f1 = fopen("alumnos1.txt", "a");
            $datos = establecerEspacios($nombre, $apellido1, $apellido2, $fechaNacimiento, $localidad);
            fwrite($f1, $datos . "\n"); 
            mensajeAviso();
            fclose($f1);

        }
            
        function establecerEspacios($nombre, $apellido1, $apellido2, $fechaNacimiento, $localidad) {
            
            $nombre = ajustaCampo($nombre, 40);
            $apellido1 = ajustaCampo($apellido1, 41);
            $apellido2 = ajustaCampo($apellido2, 42);
            $fechaNacimiento = ajustaCampo($fechaNacimiento, 10);
            $localidad = ajustaCampo($localidad, 27);

            return $nombre . $apellido1 . $apellido2 . $fechaNacimiento . $localidad;
        }

        function ajustaCampo($campo, $longitud) {
            $datoFormateado = $campo;

            while (mb_strlen($datoFormateado, 'UTF-8') < $longitud)
            $datoFormateado .= ' ';

            return $datoFormateado;
        }

        function mensajeAviso(){
            echo "<br>Los datos han sido almacenados correctamente.<br>";
        }
        

    ?>

</body>
</html>