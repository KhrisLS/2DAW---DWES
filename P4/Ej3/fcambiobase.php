<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ej3.2</title>
</head>
<body>
    <h1>CONVERSOR NUMERICO</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
        <label for="decimal">Número Decimal: </label>
        <input type="text" name="decimal"><br><br>
        <label for="operacion">Convertir a: </label><br>
        <input type="radio" name="operacion" value="binario">Binario <br>
        <input type="radio" name="operacion" value="octal">Octal <br>
        <input type="radio" name="operacion" value="hexadecimal">Hexadecimal <br>
        <input type="radio" name="operacion" value="todos">Todos Sistemas <br><br>
        <button type="submit">Enviar</button>
        <button type="reset">Borrar</button>
    </form>

    <?php 
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $num = test_input($_POST["decimal"]);
            $operacion = $_POST["operacion"];
            eleccion($num, $operacion); 
        }

        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        function eleccion($num, $operacion) {
            $binario = decimalABinario($num);
            $octal = decimalAOctal($num);
            $hexadecimal = strtoupper(decimalAHexadecimal($num));

            switch ($operacion) {
                case 'binario':
                    echo "
                        <br>
                        <form>
                            <label name='decimal'>Número Decimal: </label>
                            <input type='text' name='decimal' value='$num' readonly><br>
                        </form>
                        <br>
                        <table border='1'>
                            <tr>
                            <td>Binario</td>
                            <td>$binario</td>
                            </tr>
                        </table>
                    ";
                    break;
                
                case 'octal':
                    echo "
                        <br>
                        <form>
                            <label name='decimal'>Número Decimal: </label>
                            <input type='text' name='decimal' value='$num' readonly><br>
                        </form>
                        <br>
                        <table border='1'>
                            <tr>
                            <td>Octal</td>
                            <td>$octal</td>
                            </tr>
                        </table>
                    ";
                    break;
                
                case 'hexadecimal':
                    echo "
                        <br>
                        <form>
                            <label name='decimal'>Número Decimal: </label>
                            <input type='text' name='decimal' value='$num' readonly><br>
                        </form>
                        <br>
                        <table border='1'>
                            <tr>
                            <td>Hexadecimal</td>
                            <td>$hexadecimal</td>
                            </tr>
                        </table>
                    ";
                    break;
                
                case 'todos':
                    echo "
                        <br>
                        <form>
                            <label name='decimal'>Número Decimal: </label>
                            <input type='text' name='decimal' value='$num' readonly><br>
                        </form>
                        <br>
                        <table border='1'>
                            <tr>
                                <td>Binario</td>
                                <td>$binario</td>
                            </tr>
                            <tr>
                                <td>Octal</td>
                                <td>$octal</td>
                            </tr>
                            <tr>
                                <td>Hexadecimal</td>
                                <td>$hexadecimal</td>
                            </tr>
                        </table>
                    ";
                    break;
                
                default:
                    echo "No se ha seleccionado una operación válida.";
                    break;
            } 
        }

        function decimalABinario($num) {
            $binario = decbin($num);
            return $binario;
        }

        function decimalAOctal($num) {
            $octal = decoct($num);
            return $octal;
        }

        function decimalAHexadecimal($num) {
            $hexadecimal = dechex($num);
            return $hexadecimal;
        } 
    ?>
</body>
</html>
