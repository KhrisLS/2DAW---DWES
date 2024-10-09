<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ej4.2</title>
</head>
<body>
    <h1>CAMBIO DE BASE</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
        <label for="numero">Número: </label>
        <input type="text" name="numero"><br><br>
        <label for="base">Nueva Base: </label>
        <input type="text" name="base"><br><br>
        <button type="submit">Cambiar Base</button>
        <button type="reset">Borrar</button>
    </form>

    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $num =  test_input($_POST["numero"]);
            $base = test_input($_POST["base"]);
            convertir($num, $base);
        }

        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        function convertir($num, $base) {
            $partes = explode("/",$num);
            $numero = $partes[0];
            $baseOriginal = $partes[1];

            $resultado = base_convert($numero, $baseOriginal, $base);

            echo "<br>";
            echo "Número $numero en base $baseOriginal = $resultado en base $base";
        }
    ?>
</body>
</html>