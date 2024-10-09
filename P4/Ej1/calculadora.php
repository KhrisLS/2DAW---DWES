<html>
<body>
<h1>CALCULADORA</h1>
<?php 
$num1 = $_GET["operando1"];
$num2 = $_GET["operando2"];
$operacion = $_GET["operacion"];

if ($operacion == "suma") {
    echo suma($num1, $num2);
} elseif ($operacion == "resta") {
    echo resta($num1, $num2);
} elseif ($operacion == "producto") {
    echo producto($num1, $num2);
} elseif ($operacion == "division") {
    echo division($num1, $num2);
} else { 
    echo "No se ha seleccionado una operación válida.";
}

function suma($num1, $num2) {
    return "Resultado operación: $num1 + $num2 = " . ($num1 + $num2);
}

function resta($num1, $num2) {
    return "Resultado operación: $num1 - $num2 = " . ($num1 - $num2);
}

function producto($num1, $num2) {
    return "Resultado operación: $num1 * $num2 = " . ($num1 * $num2);
}

function division($num1, $num2) {
    if ($num2 != 0) {
        return "Resultado operación: $num1 / $num2 = " . ($num1 / $num2);
    } else {
        return "No se puede dividir por cero.";
    }
}

?>

</body>
</html>