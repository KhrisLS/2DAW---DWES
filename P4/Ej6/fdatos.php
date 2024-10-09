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
        <input type="text" name="nombre"> *Obligatorio<br><br>
        <label for="apellido1">Apellido1: </label>
        <input type="text" name="apellido1"><br><br>
        <label for="apellido2">Apellido2: </label>
        <input type="text" name="apellido2"><br><br>
        <label for="email">Email: </label>
        <input type="text" name="email" > *Obligatorio<br><br>
        <label for="sexo">Sexo: </label>
        <input type="radio" name="sexo" value="mujer">Mujer
        <input type="radio" name="sexo" value="hombre">Hombre *Obligatorio<br><br>
        <button type="submit">Enviar</button>
        <button type="reset">Borrar</button>
    </form>

    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nombre = test_input($_POST["nombre"]);
            $apellido1 = test_input($_POST["apellido1"]);
            $apellido2 = test_input($_POST["apellido2"]);
            $email = test_input($_POST["email"]);
            $sexo = isset($_POST["sexo"]) ? $_POST["sexo"] : "";

            comprobarCamposObligatorios($nombre, $apellido1, $apellido2, $email, $sexo);        
        }

        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        function comprobarCamposObligatorios($nombre, $apellido1, $apellido2, $email, $sexo) {
            if ($nombre != "" && $email!== "" && $sexo!== "") {
                $sexoElegido=establecerSexo($sexo);
                imprimirTabla($nombre, $apellido1, $apellido2, $email, $sexoElegido);
                guardarDatos($nombre, $apellido1, $apellido2, $email, $sexoElegido);

            } else {
                echo "Se deben rellenar los campos obligatorios";
            }
        }   

        function establecerSexo($sexo) {
            if ($sexo == "hombre") {
                return "H";
            } 
            if ($sexo == "mujer") {
                return "M";
            } 
        }

        function imprimirTabla($nombre, $apellido1, $apellido2, $email, $sexoElegido) {
            echo "
                <br><br>
                <table border='1'>
                    <tr>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>Email</th>
                        <th>Sexo</th>
                    </tr>
                    <tr>
                        <td>$nombre</td>
                        <td>$apellido1 $apellido2</td>
                        <td>$email</td>
                        <td>$sexoElegido</td>
                    </tr>
                </table>
            ";
        }

        function guardarDatos($nombre, $apellido1, $apellido2, $email, $sexo) {
            $datos = "Nombre: $nombre, Apellido1: $apellido1, Apellido2: $apellido2, Email: $email, Sexo: $sexo\n";
            $archivo = 'datos1.txt';
            file_put_contents($archivo, $datos, FILE_APPEND);
        } 
    ?>
</body>
</html>