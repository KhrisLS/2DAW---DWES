<?php
    require_once ("models/movdevolver_model.php");
    require_once ("controllers/funciones_controller.php");
    require_once("views/movdevolver.php");

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $matricula = $_POST['matricula'];
        $matricula = test_input($matricula);

        $cliente = $_SESSION['usuario']['idcliente'];

        if (isset($_POST['devolver'])){
            realizarDevolucion($cliente, $matricula);
        }

        if (isset($_POST['volver'])){
            header("Location: welcome.php");
            exit();
        }
        
    }

    //============================================== FUNCIONES =================================================
    function listaVehiculosAlquilados(){
        $cliente = $_SESSION['usuario']['idcliente'];
        $vehiculos = vehiculosAlquilados($cliente);

        // Opción por defecto
        echo "<option value=''>-- SELECCIONA UNA OPCIÓN --</option>";

        // Usamos los datos obtenidos
        foreach ($vehiculos as $row) {
            echo "<option value='" . $row["matricula"] . "'>" . $row['matricula'] . " - " . $row["marca"] . " - " . $row["modelo"]. "</option>";
        }
    }

    function realizarDevolucion($cliente, $matricula){
        $resultado = consultarPrecioBaseYFechaAlquiler($matricula);
        $precioBase = $resultado[0]['preciobase'];
        $fechaAlquiler = $resultado[0]['fecha_alquiler'];
        var_dump($precioBase);
        var_dump($fechaAlquiler);

        $valido = devolverVehiculo($matricula, $precioBase, $fechaAlquiler);

        if($valido){
            actualizarDisponibilidadVehiculo($matricula, 'S');
            echo "Vehiculo con matrícula $matricula, se ha devuelto correctamente.";
        }else{
            echo "No se pudo devolver el vehiculo con matrícula $matricula.";
        }
    }

?>