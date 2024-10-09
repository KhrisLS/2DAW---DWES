<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ej5.2</title>
</head>
<body>
    <h1>IPs</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
        <label for="numero">IP de notación decimal: </label>
        <input type="text" name="numero"><br><br>
        <button type="submit">Notación Binaria</button>
        <button type="reset">Borrar</button>
    </form>

    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $num = test_input($_POST["numero"]);
            validarIP($num);
        }
    
        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
    
        function validarIP($num) {
            if (filter_var($num, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
                convertir($num);
            } else {
                echo "<p style='color:red;'>IP no válida</p>";
            }
        }

        function convertir($num) {
            $octetos = explode(".",$num);
            $octetoBinarios = [];

            foreach ($octetos as $oct){
                $binario = decbin($oct);
                $binario = str_pad($binario, 8, "0", STR_PAD_LEFT);
                $octetoBinarios[] = $binario;
            }

            $cadena = implode(".", $octetoBinarios);

            imprimirBinarios($cadena, $num); 
        }

        function imprimirBinarios($cadena, $num) {
            echo "
                <br><br>
                <label for='numero'>IP de notación decimal: </label>
                <input type='text' name='numero' value='$num' readonly><br><br>
                <label for='numero'>IP Binario: </label>
                <input type='text' name='numero' value='$cadena' size='35' readonly><br><br>
            ";
        }
    ?>
</body>
</html>