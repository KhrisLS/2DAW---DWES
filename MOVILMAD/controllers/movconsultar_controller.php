<?php
    require_once ("models/movconsultar_model.php");
    require_once ("controllers/funciones_controller.php");
    require_once("views/movconsultar.php");

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $fechaDesde = $_POST['fechadesde'];
        $fechaHasta = $_POST['fechahasta'];

        $cliente = $_SESSION['usuario']['idcliente'];

        if (isset($_POST['consultar'])){
            visualizarAlquileres($cliente, $fechaDesde, $fechaHasta);
        }

        if (isset($_POST['volver'])){
            header("Location: welcome.php");
            exit();
        }
        
    }

    //============================================== FUNCIONES =================================================


    function visualizarAlquileres($cliente, $fechaDesde, $fechaHasta){
        if (empty($fechaDesde) || empty($fechaHasta)) {
            $datos = listaAlquilerTotal($cliente);
        }else{
            $datos = listaAlquilerPorFecha($cliente, $fechaDesde, $fechaHasta);
        }
    
        visualizarListadoAlquileres($datos);
    }

    function visualizarListadoAlquileres($datos){
        echo "<br><br>";
        echo "<table border='1'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Matrícula</th>";
        echo "<th>Marca</th>";
        echo "<th>Modelo</th>";
        echo "<th>Fecha Alquiler</th>";
        echo "<th>Fecha Devolucion</th>";
        echo "<th>Precio Total</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        // Iterar sobre los elementos de la cesta
        foreach ($datos as $vehiculo) {
            $matricula = $vehiculo['matricula'];
            $marca = $vehiculo['marca'];
            $modelo = $vehiculo['modelo'];
            $fecha_alquiler = $vehiculo['fecha_alquiler'];
            $fecha_devolucion = $vehiculo['fecha_devolucion'];
            $preciototal = $vehiculo['preciototal'];
            echo "<tr>";
            echo "<td>" . htmlspecialchars($matricula) . "</td>";
            echo "<td>" . htmlspecialchars($marca) . "</td>";
            echo "<td>" . htmlspecialchars($modelo) . "</td>";
            echo "<td>" . htmlspecialchars($fecha_alquiler) . "</td>";
            echo "<td>" . htmlspecialchars($fecha_devolucion) . "</td>";
            echo "<td>" . htmlspecialchars($preciototal) . "</td>";
            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";
    }

?>