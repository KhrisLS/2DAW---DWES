<html>
<body>
<h1>CONVERSOR NUMERICO</h1> 
<?php 
    $num1 = $_GET["decimal"];
    $operacion = $_GET["operacion"];
    $binario = decimalABinario($num1);
    $octal = decimalAOctal($num1);
    $hexadecimal = strtoupper(decimalAHexadecimal($num1));

    if ($operacion == "binario") {
        echo "
            <form>
                <label name='decimal'>Número Decimal: </label>
                <input type='text' name='decimal' value='$num1' readonly><br>
            </form>
            <table border='1'>
                <tr>
                <td>Binario</td>
                <td>$binario</td>
                </tr>
            </table>
        ";
    } elseif ($operacion == "octal") {
        echo "
            <form>
                <label name='decimal'>Número Decimal: </label>
                <input type='text' name='decimal' value='$num1' readonly><br>
            </form>
            <table border='1'>
                <tr>
                <td>Octal</td>
                <td>$octal</td>
                </tr>
            </table>
        ";
    } elseif ($operacion == "hexadecimal") {
        echo "
            <form>
                <label name='decimal'>Número Decimal: </label>
                <input type='text' name='decimal' value='$num1' readonly><br>
            </form>
            <table border='1'>
                <tr>
                <td>Hexadecimal</td>
                <td>$hexadecimal</td>
                </tr>
            </table>
        ";
    } elseif ($operacion == "todos") {
        echo "
            <form>
                <label name='decimal'>Número Decimal: </label>
                <input type='text' name='decimal' value='$num1' readonly><br>
            </form>
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
    } else { 
        echo "No se ha seleccionado una operación válida.";
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