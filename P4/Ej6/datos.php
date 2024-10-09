<html>
<body>
<h1>Datos Alumnos</h1>
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
        $archivo = 'datos.txt';
        file_put_contents($archivo, $datos, FILE_APPEND);
    } 
?>
</body>
</html>