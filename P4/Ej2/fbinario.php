<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ej2.2</title>
</head>
<body>
    <h1>CONVERSOR BINARIO</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
        <label for="decimal">Número Decimal: </label>
        <input type="text" name="decimal"><br><br>
        <button type="submit">Enviar</button>
        <button type="reset">Borrar</button>
    </form>

    <?php 
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $num = test_input($_POST["decimal"]);
            decimalABinario($num);
        }

        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        function decimalABinario($num) {
            $binario = decbin($num);
            
            echo "
                <br>
                <form>
                <label name='decimal'>Número Decimal: </label>
                <input type='text' name='decimal' value='$num' readonly><br><br>
                <label name='binario'>Número Binario: </label>
                <input type='text' name='binario' value='$binario' readonly>
                </form>
                ";
        }

    ?>
</body>
</html>