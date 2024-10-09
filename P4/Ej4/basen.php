<html>
<body>
<h1>CAMBIO DE BASE</h1>
<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $num =  test_input($_POST["numero"]);
        $base =  test_input($_POST["base"]);
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

        echo "Número $numero en base $baseOriginal = $resultado en base $base";
    }
?>
</body>
</html>