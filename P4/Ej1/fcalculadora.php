<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ej1.2</title>
</head>
<body>
    <h1>CALCULADORA</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
        <label for="operando1">Operando1: </label>
        <input type="text" name="operando1"><br>
        <label for="operando2">Operando2: </label>
        <input type="text" name="operando2"><br>
        <label for="operacion">Selecciona operación: </label><br>
        <input type="radio" name="operacion" value="suma">Suma <br>
        <input type="radio" name="operacion" value="resta">Resta <br>
        <input type="radio" name="operacion" value="producto">Producto <br>
        <input type="radio" name="operacion" value="division">División <br><br>
        <button type="submit">Enviar</button>
        <button type="reset">Borrar</button>
    </form>
    <?php 

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $num1 = test_input($_POST["operando1"]);
            $num2 = test_input($_POST["operando2"]);
            $operacion = $_POST["operacion"];
            operando($num1, $num2, $operacion);
        }

        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        function operando($num1, $num2, $operacion){
            switch ($operacion) {
                case 'suma':
                    $resultado=suma($num1, $num2);
                    echo "<br>";
                    echo "Resultado operación: $num1 + $num2 = $resultado";
                    break;
                
                case 'resta':
                    $resultado=resta($num1, $num2);
                    echo "<br>";
                    echo "Resultado operación: $num1 - $num2 = $resultado";
                    break;
                    
                case 'producto':
                    $resultado=producto($num1, $num2);
                    echo "<br>";
                    echo "Resultado operación: $num1 * $num2 = $resultado";
                    break;
                    
                case 'division':
                    $resultado=division($num1, $num2);
                    echo "<br>";
                    echo "Resultado operación: $num1 / $num2 = $resultado";
                    break;
                    
                default:
                echo "No se ha seleccionado una operación válida.";
            }
        }

        function suma($num1, $num2) {
            return $num1 + $num2;
        }

        function resta($num1, $num2) {
            return $num1 - $num2;
        }

        function producto($num1, $num2) {
            return $num1 * $num2;
        }

        function division($num1, $num2) {
            if ($num2 != 0) {
                return $num1 / $num2;
            } else {
                return "No se puede dividir por cero.";
            }
        }
    ?>
</body>
</html>